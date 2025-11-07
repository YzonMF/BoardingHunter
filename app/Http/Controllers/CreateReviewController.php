<?php

namespace App\Http\Controllers;

use App\Models\Create_Review;
use App\Http\Requests\StoreCreate_ReviewRequest;
use App\Http\Requests\UpdateCreate_ReviewRequest;

class CreateReviewController extends Controller
{
    /**
     * Display a listing of the resource.
    public function index()
    {
        $reviews = Create_Review::with(['seeker', 'accommodation'])->get();
        return view('reviews.index', compact('reviews'));
    }

    public function create()
    {
        $seekers = \App\Models\Seeker::all();
        $accommodations = \App\Models\Accommodation::all();
        return view('reviews.create', compact('seekers', 'accommodations'));
    }

    public function store(StoreCreate_ReviewRequest $request)
    {
        Create_Review::create($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
    }

    public function show(Create_Review $create_Review)
    {
        $review = $create_Review->load(['seeker', 'accommodation']);
        return view('reviews.show', compact('review'));
    }

    public function edit(Create_Review $create_Review)
    {
        $review = $create_Review;
        $seekers = \App\Models\Seeker::all();
        $accommodations = \App\Models\Accommodation::all();
        return view('reviews.edit', compact('review', 'seekers', 'accommodations'));
    }

    public function update(UpdateCreate_ReviewRequest $request, Create_Review $create_Review)
    {
        $create_Review->update($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Create_Review $create_Review)
    {
        $create_Review->delete();
        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
