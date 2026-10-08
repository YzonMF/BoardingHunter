@extends('layouts.layout')

@section('content')

<div class="container mt-4">
    <h2 class="mb-1">All Accommodations</h2>
    @if($site['home_tagline'])<p class="text-muted mb-4">{{ $site['home_tagline'] }}</p>@endif

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('accommodations.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-12">
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="search" 
                                   placeholder="Search by name or description..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>

                    <!-- Location Filter -->
                    <div class="col-md-3">
                        <select name="location" class="form-select">
                            <option value="">All Locations</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" 
                                    {{ request('location') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            @foreach(\App\Models\Accommodation::STATUSES as $st)
                                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text">{{ $site['currency_symbol'] }}</span>
                            <input type="number" 
                                   class="form-control" 
                                   name="min_price" 
                                   placeholder="Min{{ $priceBounds->low !== null ? ' ' . number_format($priceBounds->low, 0) : '' }}" 
                                   value="{{ request('min_price') }}"
                                   step="0.01">
                            <span class="input-group-text">-</span>
                            <input type="number" 
                                   class="form-control" 
                                   name="max_price" 
                                   placeholder="Max{{ $priceBounds->high !== null ? ' ' . number_format($priceBounds->high, 0) : '' }}" 
                                   value="{{ request('max_price') }}"
                                   step="0.01">
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Apply Filters
                        </button>
                        <a href="{{ route('accommodations.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Clear Filters
                        </a>
                        <span class="text-muted ms-3">
                            Found {{ $accommodations->count() }} accommodation(s)
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Accommodations Grid -->
    <div class="row">
        @forelse($accommodations as $acc)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Photo Section -->
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
                    No accommodations found matching your criteria.
                    <a href="{{ route('accommodations.index') }}" class="alert-link">Clear filters</a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection