@extends('layouts.layout')

@section('title', 'Edit Post - ' . $site['site_name'])

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <h2>Edit Post</h2>

    <form action="{{ route('community.update', $post->PostID) }}" method="POST">
        @csrf
        @method('PUT')
        @include('community._form')

        <p style="margin-top:20px;">
            <button type="submit">Save Changes</button>
            <a href="{{ route('community.show', $post->PostID) }}">Cancel</a>
        </p>
    </form>
</div>
@endsection
