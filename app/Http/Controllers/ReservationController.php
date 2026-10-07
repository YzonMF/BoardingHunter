<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Seekers see the reservations they made; owners see requests for their rooms.
     */
    public function index()
    {
        Reservation::expireOverdue();

        $user = Auth::user();
        $query = Reservation::with(['seeker', 'accommodation'])->orderByDesc('ReservationDate');

        if ($user->role === 'roomOwner') {
            $query->whereHas('accommodation', fn ($q) => $q->where('OwnerID', $user->UserID));
        } else {
            $query->where('SeekerID', $user->UserID);
        }

        return view('reservations.index', [
            'reservations' => $query->get(),
            'holdDays' => Reservation::HOLD_DAYS,
        ]);
    }

    /**
     * A seeker asks the owner to hold a room. The hold only starts once the owner approves.
     */
    public function store(Request $request, Accommodation $accommodation)
    {
        Reservation::expireOverdue();
        $accommodation->refresh();

        $data = $request->validate([
            'CheckInDate' => 'required|date|after_or_equal:today',
            'SpecialRequests' => 'nullable|string|max:1000',
        ]);

        if (!$accommodation->isOpen()) {
            return back()->withErrors(['reservation' => 'This room is not available for reservation right now.']);
        }

        $alreadyRequested = Reservation::where('SeekerID', Auth::id())
            ->where('AccommodationID', $accommodation->AccommodationID)
            ->whereIn('Status', ['Pending', 'Confirmed'])
            ->exists();

        if ($alreadyRequested) {
            return back()->withErrors(['reservation' => 'You already have an open reservation for this room.']);
        }

        Reservation::create([
            'SeekerID' => Auth::id(),
            'AccommodationID' => $accommodation->AccommodationID,
            'CheckInDate' => $data['CheckInDate'],
            'SpecialRequests' => $data['SpecialRequests'] ?? null,
            'Status' => 'Pending',
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation requested. The owner needs to approve it; the ' . Reservation::HOLD_DAYS . '-day hold starts on approval.');
    }

    public function approve(Request $request, Reservation $reservation)
    {
        $this->authorizeOwner($reservation);
        Reservation::expireOverdue();

        $approved = $reservation->approve($request->input('OwnerResponse'));

        return back()->with(
            $approved ? 'success' : 'error',
            $approved
                ? 'Reservation approved. The room is held for ' . Reservation::HOLD_DAYS . ' days.'
                : 'This reservation can no longer be approved (it was already handled or the room is not open).'
        );
    }

    public function reject(Request $request, Reservation $reservation)
    {
        $this->authorizeOwner($reservation);

        $rejected = $reservation->reject($request->input('OwnerResponse'));

        return back()->with($rejected ? 'success' : 'error', $rejected ? 'Reservation rejected.' : 'Only pending reservations can be rejected.');
    }

    public function cancel(Reservation $reservation)
    {
        abort_unless($reservation->SeekerID === Auth::id(), 403);

        $cancelled = $reservation->cancel();

        return back()->with($cancelled ? 'success' : 'error', $cancelled ? 'Reservation cancelled.' : 'This reservation can no longer be cancelled.');
    }

    private function authorizeOwner(Reservation $reservation): void
    {
        abort_unless($reservation->accommodation->OwnerID === Auth::id(), 403);
    }
}
