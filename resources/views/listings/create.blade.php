@extends('layouts.layout')

@section('title', 'Add Listing - ' . $site['site_name'])

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <h2>Add a Listing</h2>

    <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('listings._form')

        <p style="margin-top:20px;">
            <button type="submit">Create Listing</button>
            <a href="{{ route('listings.index') }}">Cancel</a>
        </p>
    </form>
</div>
@endsection
