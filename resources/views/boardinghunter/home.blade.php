@extends('layouts.layout')

@section('title', 'Home - Boarding Hunter')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Welcome, {{ Auth::user()->fullname }}!</h2>
        <span class="badge bg-{{ Auth::user()->role === 'roomOwner' ? 'primary' : 'success' }} fs-6">
            {{ Auth::user()->role === 'roomOwner' ? 'Room Owner' : 'Room Seeker' }}
        </span>
    </div>

    @if(Auth::user()->role === 'roomOwner')
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Owner Dashboard</h5>
                <p class="card-text">Manage your accommodation listings and respond to inquiries.</p>
                <a href="{{ route('listings.index') }}" class="btn btn-primary">Manage My Listings</a>
                <a href="{{ route('inquiries.show') }}" class="btn btn-outline-primary">View Inquiries</a>
            </div>
        </div>
    @endif

    @if(Auth::user()->role === 'roomSeeker')
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Find Your Perfect Place</h5>
                <p class="card-text">Browse available accommodations and send inquiries to owners.</p>
                <a href="{{ route('index') }}" class="btn btn-primary">Browse Accommodations</a>
                <a href="{{ route('inquiries.show') }}" class="btn btn-outline-primary">My Inquiries</a>
            </div>
        </div>
    @endif

    <hr>

    <h4 class="mb-3">Latest Accommodations</h4>
    <div class="row">
        @php
            $latestAccommodations = \App\Models\Accommodation::with(['photos', 'owner'])
                ->orderBy('date_created', 'desc')
                ->take(6)
                ->get();
        @endphp

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
                        <p class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $acc->Location }}</p>
                        <p class="card-text">{{ Str::limit($acc->Description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 text-primary mb-0">${{ number_format($acc->PricePerNight, 2) }}/night</span>
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
