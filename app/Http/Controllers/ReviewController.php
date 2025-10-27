<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Seeker;
use App\Models\Accommodation;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['seeker', 'accommodation'])->get();
        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seekers = Seeker::all();
        $accommodations = Accommodation::all();
        return view('reviews.create', compact('seekers', 'accommodations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        Review::create($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['seeker', 'accommodation']);
        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        $seekers = Seeker::all();
        $accommodations = Accommodation::all();
        return view('reviews.edit', compact('review', 'seekers', 'accommodations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
