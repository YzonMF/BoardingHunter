<?php

namespace App\Http\Controllers;

use App\Models\Create_Review;
use App\Models\Seeker;
use App\Models\Accommodation;
use App\Http\Requests\StoreCreate_ReviewRequest;
use App\Http\Requests\UpdateCreate_ReviewRequest;
use Illuminate\Http\Request;

class CreateReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Create_Review::with(['seeker.user', 'accommodation'])->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seekers = Seeker::with('user')->get();
        $accommodations = Accommodation::all();

        return view('reviews.create', compact('seekers', 'accommodations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCreate_ReviewRequest $request)
    {
        Create_Review::create($request->validated());

        return redirect()->route('reviews.index')->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Create_Review $review)
    {
        $review->load(['seeker.user', 'accommodation']);

        return view('reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Create_Review $review)
    {
        $seekers = Seeker::with('user')->get();
        $accommodations = Accommodation::all();

        return view('reviews.edit', compact('review', 'seekers', 'accommodations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCreate_ReviewRequest $request, Create_Review $review)
    {
        $review->update($request->validated());

        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Create_Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }
}
