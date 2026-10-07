@extends('layouts.layout')

@section('title', 'Notifications - ' . $site['site_name'])

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Notifications</h2>
        @if(Auth::user()->unreadNotifications()->count() > 0)
            <form action="{{ route('notifications.readall') }}" method="POST">
                @csrf
                <button type="submit">Mark all as read</button>
            </form>
        @endif
    </div>

    @forelse($notifications as $n)
        <form action="{{ route('notifications.open', $n->id) }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit"
                    style="display:block; width:100%; text-align:left; padding:12px; margin-bottom:6px; cursor:pointer; border:1px solid #ddd; border-radius:6px;
                           background:{{ $n->read_at ? '#fff' : '#eef5ff' }}; font-weight:{{ $n->read_at ? 'normal' : 'bold' }};">
                {{ $n->data['message'] }}
                <br><small style="font-weight:normal; color:#666;">{{ $n->created_at->diffForHumans() }}</small>
            </button>
        </form>
    @empty
        <p>You have no notifications yet.</p>
    @endforelse

    {{ $notifications->links() }}
</div>
@endsection
