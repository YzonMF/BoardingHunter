@extends('layouts.layout')

@section('title', 'Home - ' . $site['site_name'])

@section('content')
@php $isOwner = Auth::user()->role === 'roomOwner'; @endphp
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, {{ Auth::user()->fullname }}!</h2>
        <span class="badge bg-{{ $isOwner ? 'primary' : 'success' }} fs-6">
            {{ \App\Models\User::ROLES[Auth::user()->role] }}
        </span>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $isOwner ? 'Owner Dashboard' : 'Find Your Perfect Place' }}</h5>
            <p class="card-text">
                {{ $isOwner ? 'Manage your listings and respond to the people who want to stay.' : 'Browse accommodations, message owners, then reserve or book.' }}
            </p>

            <div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                @foreach($stats as $stat)
                    <a href="{{ $stat['url'] }}"
                       style="display:block; min-width:150px; padding:12px 16px; border:1px solid #ddd; border-radius:8px; text-decoration:none; color:inherit; text-align:center;
                              {{ $stat['value'] > 0 && $stat['label'] !== 'My listings' ? 'background:#fff7e6; border-color:#f0c36d;' : '' }}">
                        <div style="font-size:1.8rem; font-weight:bold;">{{ $stat['value'] }}</div>
                        <small>{{ $stat['label'] }}</small>
                    </a>
                @endforeach
                <a href="{{ route('notifications.index') }}"
                   style="display:block; min-width:150px; padding:12px 16px; border:1px solid #ddd; border-radius:8px; text-decoration:none; color:inherit; text-align:center;
                          {{ $unread > 0 ? 'background:#eef5ff; border-color:#9bbcf2;' : '' }}">
                    <div style="font-size:1.8rem; font-weight:bold;">{{ $unread }}</div>
                    <small>Unread notifications</small>
                </a>
            </div>

            @if($isOwner)
                <a href="{{ route('listings.index') }}" class="btn btn-primary">Manage My Listings</a>
                <a href="{{ route('listings.create') }}" class="btn btn-outline-primary">Add a Listing</a>
            @else
                <a href="{{ route('index') }}" class="btn btn-primary">Browse Accommodations</a>
            @endif
            <a href="{{ route('inquiries.show') }}" class="btn btn-outline-primary">{{ $isOwner ? 'View Inquiries' : 'My Inquiries' }}</a>
        </div>
    </div>

    @foreach($expiringHolds as $hold)
        <div class="alert alert-warning">
            Your reservation for <strong>{{ $hold->accommodation->Name }}</strong> is on hold until
            {{ $hold->ExpiresAt->format('M d, Y h:i A') }} ({{ $hold->ExpiresAt->diffForHumans() }}).
            <a href="{{ route('reservations.index') }}">Book it now</a> before it is released.
        </div>
    @endforeach

    <hr>

    <h4 class="mb-3">Latest Accommodations</h4>
    <div class="row">
        @forelse($latestAccommodations as $acc)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($acc->photos->count() > 0)
                        <img src="{{ $acc->photos->first()->FilePathURL }}"
                             class="card-img-top"
                             alt="{{ $acc->Name }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $acc->Name }}</h5>
                        <p class="text-muted small">
                            <i class="bi bi-geo-alt"></i> {{ $acc->Location }}
                            @include('partials.rating', ['room' => $acc])
                        </p>
                        <p class="card-text">{{ Str::limit($acc->Description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 text-primary mb-0">@money($acc->PricePerNight)/night</span>
                            <a href="{{ route('accommodations.show', $acc->AccommodationID) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No accommodations listed yet.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
