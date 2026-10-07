<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    /**
     * List the current user's inquiries (as seeker or as owner) and show the selected one.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $column = $user->role === 'roomOwner' ? 'OwnerID' : 'SeekerID';

        $inquiries = Inquiry::with(['seeker', 'owner', 'accommodation'])
            ->where($column, $user->UserID)
            ->orderByDesc('DateSent')
            ->get();

        $selected = $inquiries->firstWhere('InquiryID', (int) $request->query('id')) ?? $inquiries->first();

        return view('inquiries.showinquiries', compact('inquiries', 'selected'));
    }

    /**
     * A seeker sends a message to the owner of an accommodation.
     */
    public function store(Request $request, Accommodation $accommodation)
    {
        $data = $request->validate([
            'Message' => 'required|string|max:1000',
        ]);

        $inquiry = Inquiry::create([
            'SeekerID' => Auth::id(),
            'OwnerID' => $accommodation->OwnerID,
            'AccommodationID' => $accommodation->AccommodationID,
            'Message' => $data['Message'],
            'DateSent' => now(),
            'Status' => 'Pending',
        ]);

        return redirect()->route('inquiries.show', ['id' => $inquiry->InquiryID])
            ->with('success', 'Your message was sent to the owner.');
    }

    /**
     * The owner of the accommodation replies to an inquiry.
     */
    public function reply(Request $request, Inquiry $inquiry)
    {
        abort_unless($inquiry->OwnerID === Auth::id(), 403);

        $data = $request->validate([
            'Reply' => 'required|string|max:1000',
        ]);

        $inquiry->update([
            'Reply' => $data['Reply'],
            'RepliedAt' => now(),
            'Status' => 'Replied',
        ]);

        return redirect()->route('inquiries.show', ['id' => $inquiry->InquiryID])
            ->with('success', 'Reply sent.');
    }
}
