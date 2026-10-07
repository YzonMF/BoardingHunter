<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * A seeker rates a room they have a confirmed booking for.
     * Submitting again updates their existing review (one review per seeker per room).
     */
    public function store(Request $request, Accommodation $accommodation)
    {
        $data = $request->validate([
            'Rating' => 'required|integer|between:1,5',
            'Comment' => 'nullable|string|max:2000',
        ]);

        $hasStayed = Booking::where('SeekerID', Auth::id())
            ->where('AccommodationID', $accommodation->AccommodationID)
            ->where('Status', 'Confirmed')
            ->exists();

        if (!$hasStayed) {
            return back()->withErrors(['review' => 'You can only review a room after your booking has been confirmed.']);
        }

        $review = Review::where('SeekerID', Auth::id())
            ->where('AccommodationID', $accommodation->AccommodationID)
            ->first();

        if ($review) {
            $review->update($data + ['ReviewDate' => now()]);
            $message = 'Your review was updated.';
        } else {
            Review::create($data + [
                'SeekerID' => Auth::id(),
                'AccommodationID' => $accommodation->AccommodationID,
                'ReviewDate' => now(),
            ]);

            User::find($accommodation->OwnerID)?->notifyApp(
                Auth::user()->fullname . ' rated ' . $accommodation->Name . ' ' . $data['Rating'] . '/5',
                route('accommodations.show', $accommodation->AccommodationID)
            );
            $message = 'Thanks for your review!';
        }

        return redirect()->route('accommodations.show', $accommodation->AccommodationID)->with('success', $message);
    }

    /** Seekers delete their own review; admins can remove any review. */
    public function destroy(Review $review)
    {
        abort_unless(Auth::id() === $review->SeekerID || Auth::user()->role === 'admin', 403);

        $accommodationId = $review->AccommodationID;
        $review->delete();

        return redirect()->route('accommodations.show', $accommodationId)->with('success', 'Review deleted.');
    }
}
