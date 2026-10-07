<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Seekers see their bookings; owners see bookings for their rooms.
     */
    public function index()
    {
        Reservation::expireOverdue();

        $user = Auth::user();
        $query = Booking::with(['seeker', 'accommodation'])->orderByDesc('BookingDate');

        if ($user->role === 'roomOwner') {
            $query->whereHas('accommodation', fn ($q) => $q->where('OwnerID', $user->UserID));
        } else {
            $query->where('SeekerID', $user->UserID);
        }

        return view('bookings.index', ['bookings' => $query->get()]);
    }

    /**
     * A seeker books a room directly. It stays pending until the owner accepts.
     */
    public function store(Request $request, Accommodation $accommodation)
    {
        Reservation::expireOverdue();
        $accommodation->refresh();

        $data = $request->validate([
            'CheckInDate' => 'required|date|after_or_equal:today',
            'CheckOutDate' => 'nullable|date|after:CheckInDate',
            'SpecialRequests' => 'nullable|string|max:1000',
        ]);

        if (!$accommodation->isOpen()) {
            return back()->withErrors(['booking' => 'This room is not available for booking right now.']);
        }

        $alreadyRequested = Booking::where('SeekerID', Auth::id())
            ->where('AccommodationID', $accommodation->AccommodationID)
            ->whereIn('Status', ['Pending', 'Confirmed'])
            ->exists();

        if ($alreadyRequested) {
            return back()->withErrors(['booking' => 'You already have an open booking for this room.']);
        }

        Booking::create([
            'SeekerID' => Auth::id(),
            'AccommodationID' => $accommodation->AccommodationID,
            'CheckInDate' => $data['CheckInDate'],
            'CheckOutDate' => $data['CheckOutDate'] ?? null,
            'SpecialRequests' => $data['SpecialRequests'] ?? null,
            'Status' => 'Pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking requested. Waiting for the owner to accept.');
    }

    /**
     * A seeker converts their approved, unexpired reservation into a booking.
     */
    public function storeFromReservation(Request $request, Reservation $reservation)
    {
        abort_unless($reservation->SeekerID === Auth::id(), 403);
        Reservation::expireOverdue();

        $data = $request->validate([
            'CheckOutDate' => 'nullable|date|after:' . $reservation->CheckInDate->toDateString(),
        ]);

        $booking = Booking::fromReservation($reservation->fresh(), null, $data['CheckOutDate'] ?? null);

        if (!$booking) {
            return redirect()->route('reservations.index')
                ->with('error', 'This reservation is no longer active, so it cannot be booked.');
        }

        return redirect()->route('bookings.index')->with('success', 'Room booked and confirmed.');
    }

    public function accept(Request $request, Booking $booking)
    {
        $this->authorizeOwner($booking);
        Reservation::expireOverdue();

        $accepted = $booking->accept($request->input('OwnerResponse'));

        return back()->with(
            $accepted ? 'success' : 'error',
            $accepted ? 'Booking accepted. The room is now marked as booked.' : 'This booking can no longer be accepted (already handled or the room is not open).'
        );
    }

    public function reject(Request $request, Booking $booking)
    {
        $this->authorizeOwner($booking);

        $rejected = $booking->reject($request->input('OwnerResponse'));

        return back()->with($rejected ? 'success' : 'error', $rejected ? 'Booking rejected.' : 'Only pending bookings can be rejected.');
    }

    public function cancel(Booking $booking)
    {
        abort_unless($booking->SeekerID === Auth::id(), 403);

        $cancelled = $booking->cancel();

        return back()->with($cancelled ? 'success' : 'error', $cancelled ? 'Booking cancelled.' : 'This booking can no longer be cancelled.');
    }

    private function authorizeOwner(Booking $booking): void
    {
        abort_unless($booking->accommodation->OwnerID === Auth::id(), 403);
    }
}
