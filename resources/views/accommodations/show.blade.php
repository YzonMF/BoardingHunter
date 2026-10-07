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
                @auth
                    @if(Auth::id() === $accommodation->OwnerID)
                        <a href="{{ route('listings.edit', $accommodation->AccommodationID) }}">Edit this listing</a>
                    @endif
                @endauth
                <span class="badge bg-info fs-6">{{ $accommodation->Type }}</span>
            </div>

            <p class="text-muted mb-2">
                <i class="bi bi-geo-alt"></i> {{ $accommodation->Location }}
            </p>

            <span class="badge bg-{{ ['available' => 'success', 'active' => 'primary', 'reserved' => 'warning', 'booked' => 'danger'][$accommodation->status] ?? 'secondary' }} mb-3">
                {{ ucfirst($accommodation->status) }}
            </span>

            <hr>

            <h5>Description</h5>
            <p>{{ $accommodation->Description }}</p>

            @if($accommodation->amenities->isNotEmpty())
                <h5>Amenities</h5>
                <ul>
                    @foreach($accommodation->amenities as $amenity)
                        <li>
                            <strong>{{ $amenity->AmenityName }}</strong>
                            @if($amenity->Description) &mdash; {{ $amenity->Description }} @endif
                        </li>
                    @endforeach
                </ul>
            @endif

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
            <p>{{ $accommodation->owner->BusinessName ?: ($accommodation->owner->user->fullname ?? 'N/A') }}</p>

            <hr>

            <h5>Contact Owner</h5>
            @guest
                <p><a href="{{ route('login') }}">Log in</a> as a room seeker to message the owner.</p>
            @endguest
            @auth
                @if(Auth::user()->role === 'roomSeeker')
                    <form action="{{ route('inquiries.store', $accommodation->AccommodationID) }}" method="POST" class="mb-3">
                        @csrf
                        <textarea name="Message" class="form-control mb-2" rows="3" maxlength="1000"
                                  placeholder="Ask the owner about this room..." required>{{ old('Message') }}</textarea>
                        @error('Message') <div class="text-danger mb-2">{{ $message }}</div> @enderror
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                @else
                    <p class="text-muted">Only room seekers can message owners.</p>
                @endif
            @endauth

            @auth
                @if(Auth::user()->role === 'roomSeeker')
                    <hr>

                    <h5>Reserve or Book</h5>

                    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
                    @error('reservation') <div class="text-danger mb-2">{{ $message }}</div> @enderror
                    @error('booking') <div class="text-danger mb-2">{{ $message }}</div> @enderror

                    @if($accommodation->isOpen())
                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ route('reservations.store', $accommodation->AccommodationID) }}" method="POST" class="mb-3">
                                    @csrf
                                    <strong>Reserve</strong>
                                    <p class="text-muted mb-2">
                                        The owner must approve. Once approved, the room is held for
                                        {{ \App\Models\Reservation::HOLD_DAYS }} days, then released if you have not booked.
                                    </p>
                                    <label>Check-in date</label>
                                    <input type="date" name="CheckInDate" class="form-control mb-2" min="{{ now()->toDateString() }}" value="{{ old('CheckInDate') }}" required>
                                    <textarea name="SpecialRequests" class="form-control mb-2" rows="2" maxlength="1000" placeholder="Special requests (optional)"></textarea>
                                    @error('CheckInDate') <div class="text-danger mb-2">{{ $message }}</div> @enderror
                                    <button type="submit" class="btn btn-warning">Request Reservation</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('bookings.store', $accommodation->AccommodationID) }}" method="POST" class="mb-3">
                                    @csrf
                                    <strong>Book now</strong>
                                    <p class="text-muted mb-2">Book directly. The owner must accept the booking.</p>
                                    <label>Check-in date</label>
                                    <input type="date" name="CheckInDate" class="form-control mb-2" min="{{ now()->toDateString() }}" required>
                                    <label>Check-out date (optional)</label>
                                    <input type="date" name="CheckOutDate" class="form-control mb-2">
                                    <textarea name="SpecialRequests" class="form-control mb-2" rows="2" maxlength="1000" placeholder="Special requests (optional)"></textarea>
                                    <button type="submit" class="btn btn-success">Book Room</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">This room is currently {{ $accommodation->status }} and cannot be reserved or booked.</p>
                    @endif

                    <p><a href="{{ route('reservations.index') }}">My reservations</a> &middot; <a href="{{ route('bookings.index') }}">My bookings</a></p>
                @endif
            @endauth

            <small class="text-muted">
                Listed on {{ \Carbon\Carbon::parse($accommodation->date_created)->format('F d, Y') }}
            </small>
        </div>
    </div>
</div>
@endsection
