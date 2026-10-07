@extends('layouts.layout')

@section('title', 'Reservations - ' . $site['site_name'])

@section('styles')
<style>
    .req-page { max-width: 1000px; margin: 20px auto; padding: 0 16px; }
    .req-page table { width: 100%; border-collapse: collapse; }
    .req-page th, .req-page td { padding: 8px 10px; border-bottom: 1px solid #ddd; text-align: left; vertical-align: top; }
    .req-page .flash-ok { background: #d1e7dd; padding: 8px 12px; margin-bottom: 10px; }
    .req-page .flash-err { background: #f8d7da; padding: 8px 12px; margin-bottom: 10px; }
    .req-page .status { font-weight: bold; }
    .req-page form { display: inline-block; margin: 2px 0; }
    .req-page input[type=text], .req-page input[type=date] { padding: 4px; }
</style>
@endsection

@section('content')
@php $isOwner = Auth::user()->role === 'roomOwner'; @endphp
<div class="req-page">
    <h2>{{ $isOwner ? 'Reservation Requests' : 'My Reservations' }}</h2>
    <p>An approved reservation holds the room for {{ $holdDays }} days from the approval date.
        Book the room before it expires or it is released.</p>

    @if(session('success')) <div class="flash-ok">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="flash-err">{{ session('error') }}</div> @endif

    <table>
        <thead>
            <tr>
                <th>Room</th>
                @if($isOwner)<th>Seeker</th>@endif
                <th>Check-in</th>
                <th>Status</th>
                <th>Expires</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($reservations as $r)
            <tr>
                <td>
                    <a href="{{ route('accommodations.show', $r->AccommodationID) }}">{{ $r->accommodation->Name }}</a>
                    @if($r->SpecialRequests)<br><small>{{ $r->SpecialRequests }}</small>@endif
                </td>
                @if($isOwner)<td>{{ $r->seeker->fullname }}<br><small>{{ $r->seeker->contactnum }}</small></td>@endif
                <td>{{ $r->CheckInDate->format('M d, Y') }}</td>
                <td>
                    <span class="status">{{ $r->Status }}</span>
                    @if($r->OwnerResponse)<br><small>{{ $r->OwnerResponse }}</small>@endif
                </td>
                <td>
                    @if($r->Status === 'Confirmed')
                        {{ $r->ExpiresAt->format('M d, Y h:i A') }}<br>
                        <small>{{ $r->ExpiresAt->diffForHumans() }}</small>
                    @else
                        &mdash;
                    @endif
                </td>
                <td>
                    @if($isOwner && $r->Status === 'Pending')
                        <form action="{{ route('reservations.approve', $r->ReservationID) }}" method="POST">
                            @csrf
                            <input type="text" name="OwnerResponse" placeholder="Note (optional)">
                            <button type="submit">Approve</button>
                        </form>
                        <form action="{{ route('reservations.reject', $r->ReservationID) }}" method="POST">
                            @csrf
                            <button type="submit">Reject</button>
                        </form>
                    @endif

                    @if(!$isOwner && $r->isActive())
                        <form action="{{ route('reservations.book', $r->ReservationID) }}" method="POST">
                            @csrf
                            <input type="date" name="CheckOutDate" title="Check-out date (optional)">
                            <button type="submit">Book now</button>
                        </form>
                    @endif

                    @if(!$isOwner && in_array($r->Status, ['Pending', 'Confirmed']))
                        <form action="{{ route('reservations.cancel', $r->ReservationID) }}" method="POST">
                            @csrf
                            <button type="submit">Cancel</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="{{ $isOwner ? 6 : 5 }}">No reservations yet.</td></tr>
        @endforelse
        </tbody>
    </table>

    <p style="margin-top:16px;"><a href="{{ route('bookings.index') }}">{{ $isOwner ? 'View bookings' : 'My bookings' }}</a></p>
</div>
@endsection
