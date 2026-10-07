<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Reservation;
use Illuminate\Http\Request; 
class AccommodationController extends Controller
{

public function index()
{
    Reservation::expireOverdue();
    $accommodations = Accommodation::with(['photos', 'owner'])
        ->orderBy('date_created', 'desc') // Use date_created, not created_at
        ->get();
    return view('accommodations.index', compact('accommodations'));
}

public function home(Request $request)  // Add Request $request here
{
    Reservation::expireOverdue();
    $query = Accommodation::with(['photos', 'owner']);

    // Search by name or description
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
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
    
    // Get unique locations for the filter dropdown
    $locations = Accommodation::select('Location')
        ->distinct()
        ->orderBy('Location')
        ->pluck('Location');

    return view('index', compact('accommodations', 'locations'));
}

/**
 * Display the specified accommodation.
 */
public function show($id)
{
    Reservation::expireOverdue();
    $accommodation = Accommodation::with(['photos', 'owner'])->findOrFail($id);
    return view('accommodations.show', compact('accommodation'));
}
}