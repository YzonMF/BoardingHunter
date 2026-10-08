<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\Reservation;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccommodationController extends Controller
{
    public function index()
    {
        Reservation::expireOverdue();

        $accommodations = Accommodation::card()
            ->orderBy('date_created', 'desc')
            ->get();

        return view('accommodations.index', compact('accommodations'));
    }

    public function home(Request $request)
    {
        Reservation::expireOverdue();

        $query = Accommodation::card();

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%");
            });
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('Location', 'like', "%{$request->location}%");
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('Type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('PricePerNight', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('PricePerNight', '<=', $request->max_price);
        }

        $accommodations = $query->orderBy('date_created', 'desc')->get();

        // Distinct locations that actually exist, for the filter dropdown
        $locations = Accommodation::select('Location')
            ->distinct()
            ->orderBy('Location')
            ->pluck('Location');

        // Cheapest and priciest room, shown as hints in the price filter.
        $priceBounds = Accommodation::selectRaw('MIN(PricePerNight) as low, MAX(PricePerNight) as high')->first();
        $roomTypes = RoomType::names();

        return view('index', compact('accommodations', 'locations', 'priceBounds', 'roomTypes'));
    }

    /**
     * Display the specified accommodation, its reviews, and what the
     * signed-in user may do with it (e.g. leave a review).
     */
    public function show($id)
    {
        Reservation::expireOverdue();

        $accommodation = Accommodation::with(['photos', 'owner.user', 'amenities', 'reviews.seeker'])->findOrFail($id);

        $reviews = $accommodation->reviews->sortByDesc('ReviewDate');
        $avgRating = $reviews->avg('Rating');
        $myReview = Auth::check() ? $reviews->firstWhere('SeekerID', Auth::id()) : null;

        // Only seekers with a confirmed booking for this room may review it.
        $canReview = Auth::check()
            && Auth::user()->role === 'roomSeeker'
            && Booking::where('SeekerID', Auth::id())
                ->where('AccommodationID', $accommodation->AccommodationID)
                ->where('Status', 'Confirmed')
                ->exists();

        return view('accommodations.show', compact('accommodation', 'reviews', 'avgRating', 'myReview', 'canReview'));
    }
}
