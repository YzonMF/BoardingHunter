<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\Inquiry;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

/**
 * The signed-in home page for owners and seekers: live numbers that need
 * their attention, plus the newest listings.
 */
class HomeController extends Controller
{
    public function dashboard()
    {
        Reservation::expireOverdue();

        $user = Auth::user();

        if ($user->role === 'roomOwner') {
            $mine = fn ($q) => $q->where('OwnerID', $user->UserID);

            $stats = [
                ['label' => 'My listings', 'value' => Accommodation::where('OwnerID', $user->UserID)->count(), 'url' => route('listings.index')],
                ['label' => 'Unanswered inquiries', 'value' => Inquiry::where('OwnerID', $user->UserID)->where('Status', 'Pending')->count(), 'url' => route('inquiries.show')],
                ['label' => 'Reservation requests', 'value' => Reservation::where('Status', 'Pending')->whereHas('accommodation', $mine)->count(), 'url' => route('reservations.index')],
                ['label' => 'Booking requests', 'value' => Booking::where('Status', 'Pending')->whereHas('accommodation', $mine)->count(), 'url' => route('bookings.index')],
                ['label' => 'Rooms on hold', 'value' => Reservation::where('Status', 'Confirmed')->whereHas('accommodation', $mine)->count(), 'url' => route('reservations.index')],
            ];
        } else {
            $stats = [
                ['label' => 'My reservations', 'value' => Reservation::where('SeekerID', $user->UserID)->whereIn('Status', ['Pending', 'Confirmed'])->count(), 'url' => route('reservations.index')],
                ['label' => 'My bookings', 'value' => Booking::where('SeekerID', $user->UserID)->whereIn('Status', ['Pending', 'Confirmed'])->count(), 'url' => route('bookings.index')],
                ['label' => 'Inquiries awaiting a reply', 'value' => Inquiry::where('SeekerID', $user->UserID)->where('Status', 'Pending')->count(), 'url' => route('inquiries.show')],
            ];
        }

        // A seeker's approved holds that are about to run out are worth surfacing.
        $expiringHolds = $user->role === 'roomSeeker'
            ? Reservation::with('accommodation')
                ->where('SeekerID', $user->UserID)
                ->where('Status', 'Confirmed')
                ->orderBy('ExpiresAt')
                ->get()
            : collect();

        return view('boardinghunter.home', [
            'stats' => $stats,
            'expiringHolds' => $expiringHolds,
            'unread' => $user->unreadNotifications()->count(),
            'latestAccommodations' => Accommodation::card()->orderBy('date_created', 'desc')->take(6)->get(),
        ]);
    }
}
