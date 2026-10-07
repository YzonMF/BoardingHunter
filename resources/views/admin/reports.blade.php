@extends('layouts.admin')

@section('title', 'Reports - ' . $site['site_name'])

@section('content')
<div style="max-width:1200px; margin:20px auto; padding:0 15px;">
    <h1 class="mb-4">Reports</h1>

    <div class="row">
        @foreach([
            ['Users by role', $usersByRole],
            ['Listings by type', $listingsByType],
            ['Listings by status', $listingsByStatus],
            ['Reservations by status', $reservationsByStatus],
            ['Bookings by status', $bookingsByStatus],
        ] as [$title, $counts])
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header"><strong>{{ $title }}</strong></div>
                    <ul class="list-group list-group-flush">
                        @forelse($counts as $label => $total)
                            <li class="list-group-item d-flex justify-content-between">{{ $label }} <span class="badge bg-secondary">{{ $total }}</span></li>
                        @empty
                            <li class="list-group-item text-muted">No data yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endforeach

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header"><strong>Reviews</strong></div>
                <div class="card-body">
                    <p class="mb-1"><strong>{{ $reviewCount }}</strong> review(s)</p>
                    <p class="mb-0">Average rating: <strong>{{ $averageRating ? number_format($averageRating, 2) . ' / 5' : '—' }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header"><strong>Bookings per month (last 6 months)</strong></div>
                <ul class="list-group list-group-flush">
                    @foreach($bookingsPerMonth as $month => $total)
                        <li class="list-group-item d-flex justify-content-between">{{ $month }} <span class="badge bg-primary">{{ $total }}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header"><strong>Top rated listings</strong></div>
                <ul class="list-group list-group-flush">
                    @forelse($topRated as $room)
                        <li class="list-group-item d-flex justify-content-between">
                            <a href="{{ route('accommodations.show', $room->AccommodationID) }}">{{ $room->Name }}</a>
                            <span>{{ number_format($room->reviews_avg_rating, 1) }} ({{ $room->reviews_count }})</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No reviews yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header"><strong>Most booked listings</strong></div>
                <ul class="list-group list-group-flush">
                    @forelse($mostBooked as $room)
                        <li class="list-group-item d-flex justify-content-between">
                            <a href="{{ route('accommodations.show', $room->AccommodationID) }}">{{ $room->Name }}</a>
                            <span class="badge bg-success">{{ $room->bookings_count }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No confirmed bookings yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
