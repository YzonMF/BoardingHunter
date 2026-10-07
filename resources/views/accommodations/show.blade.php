@extends('layouts.layout')

@section('title', $accommodation->Name . ' - Boarding Hunter')

@section('content')
<div class="container mt-4">
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">&larr; Back</a>

    <div class="card">
        <!-- Photo Gallery -->
        @if($accommodation->photos->count() > 0)
            <div style="display:flex; overflow-x:auto; gap:10px; padding:10px; background:#f8f9fa;">
                @foreach($accommodation->photos as $photo)
                    <img src="{{ $photo->FilePathURL }}" 
                         alt="{{ $photo->Caption ?? $accommodation->Name }}"
                         style="height:300px; object-fit:cover; border-radius:8px;">
                @endforeach
            </div>
        @else
            <div class="bg-light d-flex align-items-center justify-content-center" style="height:300px;">
                <span class="text-muted">No Images Available</span>
            </div>
        @endif

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h2 class="card-title mb-0">{{ $accommodation->Name }}</h2>
                <span class="badge bg-info fs-6">{{ $accommodation->Type }}</span>
            </div>

            <p class="text-muted mb-2">
                <i class="bi bi-geo-alt"></i> {{ $accommodation->Location }}
            </p>

            <span class="badge bg-{{ $accommodation->status === 'available' ? 'success' : ($accommodation->status === 'active' ? 'primary' : 'secondary') }} mb-3">
                {{ ucfirst($accommodation->status) }}
            </span>

            <hr>

            <h5>Description</h5>
            <p>{{ $accommodation->Description }}</p>

            <hr>

            <h5>Pricing</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light p-3 text-center">
                        <span class="h4 text-primary">${{ number_format($accommodation->PricePerNight, 2) }}</span>
                        <small class="text-muted">per night</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light p-3 text-center">
                        <span class="h4 text-success">${{ number_format($accommodation->PricePerMonth, 2) }}</span>
                        <small class="text-muted">per month</small>
                    </div>
                </div>
            </div>

            <hr>

            <h5>Owner</h5>
            <p>{{ $accommodation->owner->BusinessName ?? 'N/A' }}</p>

            <small class="text-muted">
                Listed on {{ \Carbon\Carbon::parse($accommodation->date_created)->format('F d, Y') }}
            </small>
        </div>
    </div>
</div>
@endsection
