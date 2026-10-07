@extends('layouts.admin')

@section('title', 'Manage Listings - Boarding Hunter')

@section('content')
<div style="max-width:1200px; margin:20px auto; padding:0 15px;">
    <h1 class="mb-3">Listings</h1>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <form action="{{ route('admin.listings') }}" method="GET" class="row g-2 mb-3">
        <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name or location"></div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All statuses</option>
                @foreach(['active', 'available', 'reserved', 'booked', 'inactive'] as $st)
                    <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><button class="btn btn-primary" type="submit">Filter</button> <a href="{{ route('admin.listings') }}" class="btn btn-link">Reset</a></div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr><th>Listing</th><th>Owner</th><th>Type</th><th>Location</th><th>Rating</th><th>Bookings</th><th>Status</th><th style="width:260px;">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($listings as $room)
                <tr>
                    <td><a href="{{ route('accommodations.show', $room->AccommodationID) }}">{{ $room->Name }}</a></td>
                    <td>{{ $room->owner->user->fullname ?? 'Unknown' }}</td>
                    <td>{{ $room->Type }}</td>
                    <td>{{ $room->Location }}</td>
                    <td>{{ $room->reviews_count ? number_format($room->reviews_avg_rating, 1) . ' (' . $room->reviews_count . ')' : '—' }}</td>
                    <td>{{ $room->bookings_count }}</td>
                    <td><span class="badge bg-{{ ['available' => 'success', 'active' => 'primary', 'reserved' => 'warning', 'booked' => 'danger'][$room->status] ?? 'secondary' }}">{{ ucfirst($room->status) }}</span></td>
                    <td>
                        @if(in_array($room->status, ['reserved', 'booked']))
                            <small class="text-muted">Managed automatically</small>
                        @else
                            <form action="{{ route('admin.listings.status', $room->AccommodationID) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                @if($room->status === 'inactive')
                                    <input type="hidden" name="status" value="active">
                                    <button class="btn btn-sm btn-success" type="submit">Reactivate</button>
                                @else
                                    <input type="hidden" name="status" value="inactive">
                                    <button class="btn btn-sm btn-warning" type="submit">Deactivate</button>
                                @endif
                            </form>
                        @endif
                        <form action="{{ route('admin.listings.destroy', $room->AccommodationID) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Permanently delete this listing and its photos?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">No listings found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $listings->links() }}
</div>
@endsection
