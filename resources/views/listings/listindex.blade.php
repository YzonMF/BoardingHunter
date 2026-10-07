@extends('layouts.layout')

@section('title', 'My Listings - Boarding Hunter')

@section('content')
<div style="max-width:1000px; margin:20px auto; padding:0 16px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>My Listings</h2>
        <a href="{{ route('listings.create') }}">+ Add listing</a>
    </div>

    @if(session('success')) <div style="background:#d1e7dd; padding:8px 12px; margin-bottom:10px;">{{ session('success') }}</div> @endif
    @if(session('error')) <div style="background:#f8d7da; padding:8px 12px; margin-bottom:10px;">{{ session('error') }}</div> @endif

    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="text-align:left;">
                <th style="padding:8px;">Photo</th>
                <th style="padding:8px;">Name</th>
                <th style="padding:8px;">Type</th>
                <th style="padding:8px;">Location</th>
                <th style="padding:8px;">Per month</th>
                <th style="padding:8px;">Status</th>
                <th style="padding:8px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($listings as $room)
            <tr style="border-top:1px solid #ddd;">
                <td style="padding:8px;">
                    @if($room->photos->isNotEmpty())
                        <img src="{{ $room->photos->first()->FilePathURL }}" alt="" style="width:80px; height:56px; object-fit:cover; border-radius:4px;">
                    @endif
                </td>
                <td style="padding:8px;"><a href="{{ route('accommodations.show', $room->AccommodationID) }}">{{ $room->Name }}</a></td>
                <td style="padding:8px;">{{ $room->Type }}</td>
                <td style="padding:8px;">{{ $room->Location }}</td>
                <td style="padding:8px;">{{ number_format($room->PricePerMonth, 2) }}</td>
                <td style="padding:8px;"><strong>{{ ucfirst($room->status) }}</strong></td>
                <td style="padding:8px;">
                    <a href="{{ route('listings.edit', $room->AccommodationID) }}">Edit</a>
                    <form action="{{ route('listings.destroy', $room->AccommodationID) }}" method="POST" style="display:inline;"
                          onsubmit="return confirm('Delete this listing and its photos?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="padding:16px;">You have no listings yet. <a href="{{ route('listings.create') }}">Add your first one.</a></td></tr>
        @endforelse
        </tbody>
    </table>

    <p style="margin-top:16px;">
        <a href="{{ route('reservations.index') }}">Reservation requests</a> &middot;
        <a href="{{ route('bookings.index') }}">Bookings</a> &middot;
        <a href="{{ route('inquiries.show') }}">Inquiries</a>
    </p>
</div>
@endsection
