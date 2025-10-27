<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;

class AccommodationController extends Controller
{
    public function index()
    {
        // Eager load photos to avoid N+1 queries
        $accommodations = Accommodation::with('photos', 'owner')->get();
        return view('accommodations.index', compact('accommodations'));
    }
}
