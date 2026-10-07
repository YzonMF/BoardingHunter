@extends('layouts.layout')

@section('title', 'All Accommodations - ' . $site['site_name'])

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Accommodations</h2>

    <div class="row">
        @forelse($accommodations as $acc)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($acc->photos->count() > 0)
                        <img src="{{ $acc->photos->first()->FilePathURL }}" 
                             class="card-img-top" 
                             alt="{{ $acc->Name }}"
                             style="height: 250px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 250px;">
                            <span class="text-muted">No Image Available</span>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $acc->Name }}</h5>
                            <span class="badge bg-info">{{ $acc->Type }}</span>
                        </div>
                        
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="bi bi-geo-alt"></i> {{ $acc->Location }}
                                &middot; @include('partials.rating', ['room' => $acc])
                            </small>
                        </p>
                        
                        <p class="card-text">{{ Str::limit($acc->Description, 100) }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="h5 text-primary mb-0">
                                        @money($acc->PricePerNight)
                                    </span>
                                    <small class="text-muted">/night</small>
                                </div>
                                <span class="badge bg-{{ ['available' => 'success', 'reserved' => 'warning', 'booked' => 'danger'][$acc->status] ?? 'secondary' }}">
                                    {{ ucfirst($acc->status) }}
                                </span>
                            </div>
                            
                            <a href="{{ route('accommodations.show', $acc->AccommodationID) }}" 
                               class="btn btn-primary w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-footer text-muted small">
                        <i class="bi bi-person"></i> {{ $acc->owner->displayName() }}
                        <span class="float-end">
                            {{ \Carbon\Carbon::parse($acc->date_created)->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> 
                    No accommodations found.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
