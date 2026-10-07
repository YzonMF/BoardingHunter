@extends('layouts.layout')

@section('title', $post->Title . ' - Boarding Hunter')

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <p><a href="{{ route('community.index') }}">&larr; Back to community</a></p>

    @if(session('success')) <div style="background:#d1e7dd; padding:8px 12px; margin:10px 0;">{{ session('success') }}</div> @endif

    <h2>{{ $post->Title }}</h2>
    <small style="color:#666;">
        {{ $post->author->fullname ?? 'Former user' }} &middot; {{ $post->PostDate->format('M d, Y h:i A') }}
    </small>

    <div style="margin:16px 0; white-space:pre-wrap;">{{ $post->Content }}</div>

    @auth
        @if(Auth::id() === $post->UserID)
            <a href="{{ route('community.edit', $post->PostID) }}">Edit</a>
        @endif
        @if(Auth::id() === $post->UserID || Auth::user()->role === 'admin')
            <form action="{{ route('community.destroy', $post->PostID) }}" method="POST" style="display:inline;"
                  onsubmit="return confirm('Delete this post?');">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @endif
    @endauth
</div>
@endsection
