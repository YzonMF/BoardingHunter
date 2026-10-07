<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\CommunityPost;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Admin dashboard, listing moderation and reports.
 */
class AdminController extends Controller
{
    public function dashboard()
    {
        Reservation::expireOverdue();

        return view('admin.dashboard', [
            'usersByRole' => User::select('role', DB::raw('COUNT(*) as total'))->groupBy('role')->pluck('total', 'role'),
            'listingCount' => Accommodation::count(),
            'activeReservations' => Reservation::where('Status', 'Confirmed')->count(),
            'pendingRequests' => Reservation::where('Status', 'Pending')->count() + Booking::where('Status', 'Pending')->count(),
            'confirmedBookings' => Booking::where('Status', 'Confirmed')->count(),
            'recentUsers' => User::orderByDesc('created_at')->limit(5)->get(),
            'recentBookings' => Booking::with(['seeker', 'accommodation'])->orderByDesc('BookingDate')->limit(5)->get(),
            'recentPosts' => CommunityPost::with('author')->orderByDesc('PostDate')->limit(5)->get(),
        ]);
    }

    public function listings(Request $request)
    {
        Reservation::expireOverdue();

        $listings = Accommodation::with(['owner.user'])
            ->withCount(['reviews', 'bookings'])
            ->withAvg('reviews', 'Rating')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . $request->input('q') . '%';
                $query->where(fn ($q) => $q->where('Name', 'like', $term)->orWhere('Location', 'like', $term));
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->orderByDesc('date_created')
            ->paginate(15)
            ->withQueryString();

        return view('admin.listings', compact('listings'));
    }

    /** Hide (inactive) or re-open (active/available) a listing. Reserved/booked rooms are system-managed. */
    public function updateListingStatus(Request $request, Accommodation $accommodation)
    {
        Reservation::expireOverdue();
        $accommodation->refresh();

        $data = $request->validate(['status' => ['required', Rule::in(['active', 'available', 'inactive'])]]);

        if (in_array($accommodation->status, ['reserved', 'booked'], true)) {
            return back()->with('error', 'This room is currently ' . $accommodation->status . ' and its status is managed automatically.');
        }

        $accommodation->update(['status' => $data['status']]);

        return back()->with('success', $accommodation->Name . ' is now ' . $data['status'] . '.');
    }

    public function destroyListing(Accommodation $accommodation)
    {
        Reservation::expireOverdue();

        $hasOpenRequests = $accommodation->reservations()->whereIn('Status', ['Pending', 'Confirmed'])->exists()
            || $accommodation->bookings()->whereIn('Status', ['Pending', 'Confirmed'])->exists();

        if ($hasOpenRequests) {
            return back()->with('error', 'This listing has open reservations or bookings and cannot be deleted yet.');
        }

        $accommodation->photos->each->deleteStoredFile();
        $accommodation->delete();

        return back()->with('success', 'Listing deleted.');
    }

    public function reports()
    {
        Reservation::expireOverdue();

        $statusCounts = fn (string $model) => $model::select('Status', DB::raw('COUNT(*) as total'))->groupBy('Status')->pluck('total', 'Status');

        $months = collect(range(5, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));
        $bookingsPerMonth = $months->mapWithKeys(fn ($month) => [
            $month->format('M Y') => Booking::whereBetween('BookingDate', [$month, $month->copy()->endOfMonth()])->count(),
        ]);

        return view('admin.reports', [
            'usersByRole' => User::select('role', DB::raw('COUNT(*) as total'))->groupBy('role')->pluck('total', 'role'),
            'listingsByType' => Accommodation::select('Type', DB::raw('COUNT(*) as total'))->groupBy('Type')->pluck('total', 'Type'),
            'listingsByStatus' => Accommodation::select('status', DB::raw('COUNT(*) as total'))->groupBy('status')->pluck('total', 'status'),
            'reservationsByStatus' => $statusCounts(Reservation::class),
            'bookingsByStatus' => $statusCounts(Booking::class),
            'bookingsPerMonth' => $bookingsPerMonth,
            'reviewCount' => Review::count(),
            'averageRating' => Review::avg('Rating'),
            'topRated' => Accommodation::withAvg('reviews', 'Rating')->withCount('reviews')
                ->having('reviews_count', '>', 0)->orderByDesc('reviews_avg_rating')->orderByDesc('reviews_count')->limit(5)->get(),
            'mostBooked' => Accommodation::withCount(['bookings' => fn ($q) => $q->where('Status', 'Confirmed')])
                ->having('bookings_count', '>', 0)->orderByDesc('bookings_count')->limit(5)->get(),
        ]);
    }
}
