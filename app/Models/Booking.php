<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'BookingID';

    // The table only has BookingDate, not created_at/updated_at.
    public $timestamps = false;

    protected $fillable = [
        'SeekerID',
        'AccommodationID',
        'ReservationID',
        'CheckInDate',
        'CheckOutDate',
        'SpecialRequests',
        'OwnerResponse',
        'Status',
    ];

    protected $casts = [
        'CheckInDate' => 'date',
        'CheckOutDate' => 'date',
        'BookingDate' => 'datetime',
    ];

    public function seeker()
    {
        return $this->belongsTo(User::class, 'SeekerID', 'UserID');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class, 'AccommodationID', 'AccommodationID');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'ReservationID', 'ReservationID');
    }

    /** Owner accepts a pending booking: the room becomes booked. */
    public function accept(?string $response = null): bool
    {
        return DB::transaction(function () use ($response) {
            $room = Accommodation::lockForUpdate()->find($this->AccommodationID);

            if ($this->Status !== 'Pending' || !$room->isOpen()) {
                return false;
            }

            $this->update(['Status' => 'Confirmed', 'OwnerResponse' => $response]);
            $room->update(['status' => 'booked']);

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

    /** Seeker cancels; a confirmed booking frees the room again. */
    public function cancel(): bool
    {
        return DB::transaction(function () {
            if (!in_array($this->Status, ['Pending', 'Confirmed'], true)) {
                return false;
            }

            if ($this->Status === 'Confirmed') {
                Accommodation::where('AccommodationID', $this->AccommodationID)
                    ->where('status', 'booked')
                    ->update(['status' => Accommodation::RELEASED_STATUS]);
            }

            $this->update(['Status' => 'Cancelled']);

            return true;
        });
    }

    /**
     * Seeker turns an active (approved, unexpired) reservation into a booking.
     * The owner already approved the hold, so the booking is confirmed straight away.
     * Returns null if the reservation can no longer be converted.
     */
    public static function fromReservation(Reservation $reservation, ?string $specialRequests = null, $checkOut = null): ?self
    {
        return DB::transaction(function () use ($reservation, $specialRequests, $checkOut) {
            $locked = Reservation::lockForUpdate()->find($reservation->ReservationID);

            if (!$locked->isActive()) {
                return null;
            }

            $booking = static::create([
                'SeekerID' => $locked->SeekerID,
                'AccommodationID' => $locked->AccommodationID,
                'ReservationID' => $locked->ReservationID,
                'CheckInDate' => $locked->CheckInDate,
                'CheckOutDate' => $checkOut,
                'SpecialRequests' => $specialRequests ?? $locked->SpecialRequests,
                'Status' => 'Confirmed',
            ]);

            $locked->update(['Status' => 'Converted']);
            Accommodation::where('AccommodationID', $locked->AccommodationID)->update(['status' => 'booked']);

            return $booking;
        });
    }
}
