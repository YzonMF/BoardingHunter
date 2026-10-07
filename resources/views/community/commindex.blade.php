@extends('layouts.layout')

@section('title', 'Community - ' . $site['site_name'])

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Community</h2>
        @auth
            <a href="{{ route('community.create') }}">+ New post</a>
        @else
            <a href="{{ route('login') }}">Log in to post</a>
        @endauth
    </div>

    @if(session('success')) <div style="background:#d1e7dd; padding:8px 12px; margin:10px 0;">{{ session('success') }}</div> @endif

    <form action="{{ route('community.index') }}" method="GET" style="margin:12px 0;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search posts" style="padding:6px; width:70%;">
        <button type="submit">Search</button>
        @if(request('q')) <a href="{{ route('community.index') }}">Clear</a> @endif
    </form>

    @forelse($posts as $post)
        <div style="border:1px solid #ddd; border-radius:6px; padding:12px; margin-bottom:10px;">
            <h4 style="margin:0 0 4px;"><a href="{{ route('community.show', $post->PostID) }}">{{ $post->Title }}</a></h4>
            <small style="color:#666;">
                {{ $post->author->fullname ?? 'Former user' }}
                @if($post->author) ({{ $post->author->role === 'roomOwner' ? 'Owner' : ($post->author->role === 'admin' ? 'Admin' : 'Seeker') }}) @endif
                &middot; {{ $post->PostDate->diffForHumans() }}
            </small>
            <p style="margin:8px 0 0;">{{ \Illuminate\Support\Str::limit($post->Content, 200) }}</p>
        </div>
    @empty
        <p>{{ request('q') ? 'No posts match your search.' : 'No posts yet. Be the first to post!' }}</p>
    @endforelse

    {{ $posts->links() }}
</div>
@endsection
