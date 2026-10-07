<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory;

    /** How long an approved reservation holds the room. */
    public const HOLD_DAYS = 7;

    protected $primaryKey = 'ReservationID';

    // The table only has ReservationDate, not created_at/updated_at.
    public $timestamps = false;

    protected $fillable = [
        'SeekerID',
        'AccommodationID',
        'CheckInDate',
        'SpecialRequests',
        'OwnerResponse',
        'Status',
        'ApprovedAt',
        'ExpiresAt',
    ];

    protected $casts = [
        'CheckInDate' => 'date',
        'ReservationDate' => 'datetime',
        'ApprovedAt' => 'datetime',
        'ExpiresAt' => 'datetime',
    ];

    public function seeker()
    {
        return $this->belongsTo(User::class, 'SeekerID', 'UserID');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID', 'AccommodationID');
    }

    /** True while the owner has approved the hold and it has not run out. */
    public function isActive(): bool
    {
        return $this->Status === 'Confirmed' && $this->ExpiresAt && $this->ExpiresAt->isFuture();
    }

    /**
     * Owner approves: the room is held for HOLD_DAYS starting now.
     * Returns false if the room is no longer open.
     */
    public function approve(?string $response = null): bool
    {
        return DB::transaction(function () use ($response) {
            $room = Accommodation::lockForUpdate()->find($this->AccommodationID);

            if ($this->Status !== 'Pending' || !$room->isOpen()) {
                return false;
            }

            $now = now();
            $this->update([
                'Status' => 'Confirmed',
                'OwnerResponse' => $response,
                'ApprovedAt' => $now,
                'ExpiresAt' => $now->copy()->addDays(self::HOLD_DAYS),
            ]);
            $room->update(['status' => 'reserved']);

            return true;
        });
    }

    public function reject(?string $response = null): bool
    {
        if ($this->Status !== 'Pending') {
            return false;
        }

        $this->update(['Status' => 'Rejected', 'OwnerResponse' => $response]);

        return true;
    }

    /** Seeker withdraws a pending request or gives up an approved hold. */
    public function cancel(): bool
    {
        return $this->release('Cancelled', ['Pending', 'Confirmed']);
    }

    /** Frees the room and marks the reservation as lapsed. */
    public function expire(): bool
    {
        if (!$this->release('Expired', ['Confirmed'])) {
            return false;
        }

        $room = $this->accommodation;
        $this->seeker?->notifyApp(
            'Your reservation for ' . $room->Name . ' expired because it was not booked within ' . self::HOLD_DAYS . ' days.',
            route('reservations.index')
        );
        User::find($room->OwnerID)?->notifyApp(
            'The reservation by ' . $this->seeker?->fullname . ' for ' . $room->Name . ' expired. The room is available again.',
            route('reservations.index')
        );

        return true;
    }

    /**
     * Marks every approved reservation past its expiry as Expired and frees the rooms.
     * Called by the scheduled command and before reads, so a missed scheduler run
     * can never leave a room locked.
     */
    public static function expireOverdue(): int
    {
        $count = 0;

        static::where('Status', 'Confirmed')
            ->where('ExpiresAt', '<=', now())
            ->get()
            ->each(function (self $reservation) use (&$count) {
                $count += $reservation->expire() ? 1 : 0;
            });

        return $count;
    }

    private function release(string $newStatus, array $from): bool
    {
        return DB::transaction(function () use ($newStatus, $from) {
            $reservation = static::lockForUpdate()->find($this->ReservationID);

            if (!in_array($reservation->Status, $from, true)) {
                return false;
            }

            $wasHolding = $reservation->Status === 'Confirmed';
            $reservation->update(['Status' => $newStatus]);

            if ($wasHolding) {
                Accommodation::where('AccommodationID', $reservation->AccommodationID)
                    ->where('status', 'reserved')
                    ->update(['status' => Accommodation::RELEASED_STATUS]);
            }

            $this->setRawAttributes($reservation->getAttributes(), true);

            return true;
        });
    }
}
