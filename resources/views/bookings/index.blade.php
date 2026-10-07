@extends('layouts.layout')

@section('title', 'Bookings - Boarding Hunter')

@section('styles')
<style>
    .req-page { max-width: 1000px; margin: 20px auto; padding: 0 16px; }
    .req-page table { width: 100%; border-collapse: collapse; }
    .req-page th, .req-page td { padding: 8px 10px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: top; }
    .req-page .flash-ok { background: #d1e7dd; padding: 8px 12px; margin-bottom: 10px; }
    .req-page .flash-err { background: #f8d7da; padding: 8px 12px; margin-bottom: 10px; }
    .req-page .status { font-weight: bold; }
    .req-page form { display: inline-block; margin: 2px 0; }
    .req-page input[type=text] { padding: 4px; }
</style>
@endsection

@section('content')
@php $isOwner = Auth::user()->role === 'roomOwner'; @endphp
<div class="req-page">
    <h2>{{ $isOwner ? 'Bookings' : 'My Bookings' }}</h2>

    @if(session('success')) <div class="flash-ok">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="flash-err">{{ session('error') }}</div> @endif

    <table>
        <thead>
            <tr>
                <th>Room</th>
                @if($isOwner)<th>Seeker</th>@endif
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($bookings as $b)
            <tr>
                <td>
                    <a href="{{ route('accommodations.show', $b->AccommodationID) }}">{{ $b->accommodation->Name }}</a>
                    @if($b->ReservationID)<br><small>From reservation #{{ $b->ReservationID }}</small>@endif
                    @if($b->SpecialRequests)<br><small>{{ $b->SpecialRequests }}</small>@endif
                </td>
                @if($isOwner)<td>{{ $b->seeker->fullname }}<br><small>{{ $b->seeker->contactnum }}</small></td>@endif
                <td>{{ $b->CheckInDate->format('M d, Y') }}</td>
                <td>{{ $b->CheckOutDate ? $b->CheckOutDate->format('M d, Y') : 'Open-ended' }}</td>
                <td>
                    <span class="status">{{ $b->Status }}</span>
                    @if($b->OwnerResponse)<br><small>{{ $b->OwnerResponse }}</small>@endif
                </td>
                <td>
                    @if($isOwner && $b->Status === 'Pending')
                        <form action="{{ route('bookings.accept', $b->BookingID) }}" method="POST">
                            @csrf
                            <input type="text" name="OwnerResponse" placeholder="Note (optional)">
                            <button type="submit">Accept</button>
                        </form>
                        <form action="{{ route('bookings.reject', $b->BookingID) }}" method="POST">
                            @csrf
                            <button type="submit">Reject</button>
                        </form>
                    @endif

                    @if(!$isOwner && in_array($b->Status, ['Pending', 'Confirmed']))
                        <form action="{{ route('bookings.cancel', $b->BookingID) }}" method="POST">
                            @csrf
                            <button type="submit">Cancel</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="{{ $isOwner ? 6 : 5 }}">No bookings yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    <p style="margin-top:16px;"><a href="{{ route('reservations.index') }}">{{ $isOwner ? 'View reservations' : 'My reservations' }}</a></p>
</div>
@endsection
