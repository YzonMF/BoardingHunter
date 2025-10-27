<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;

class AccommodationController extends Controller
{
    public function index()
    {
        // Eager load photos to avoid N+1 queries
        $accommodations = Accommodation::with('photo', 'owner')->get();
        return view('accommodations.index', compact('accommodations'));
    }
    public function show(Accommodation $accommodations)
    {
        $accommodations = Accommodation::with('photo', 'owner')->get();
        return view('accomodations.index', compact('accommodations'));
    }
}
