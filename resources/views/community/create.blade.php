@extends('layouts.layout')

@section('title', 'New Post - Boarding Hunter')

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <h2>New Post</h2>

    <form action="{{ route('community.store') }}" method="POST">
        @csrf
        @include('community._form')

        <p style="margin-top:20px;">
            <button type="submit">Publish</button>
            <a href="{{ route('community.index') }}">Cancel</a>
        </p>
    </form>
</div>
@endsection
