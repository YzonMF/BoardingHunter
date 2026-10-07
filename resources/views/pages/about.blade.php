@extends('layouts.layout')

@section('title', 'About & Contact - ' . $site['site_name'])

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <h2>About {{ $site['site_name'] }}</h2>
    <p style="white-space:pre-line;">{{ $site['about_text'] }}</p>

    <h3 id="contact" style="margin-top:28px;">Contact us</h3>
    <ul style="list-style:none; padding:0;">
        <li><strong>Email:</strong> <a href="mailto:{{ $site['contact_email'] }}">{{ $site['contact_email'] }}</a></li>
        @if($site['contact_phone'])<li><strong>Phone:</strong> {{ $site['contact_phone'] }}</li>@endif
        @if($site['address'])<li><strong>Address:</strong> {{ $site['address'] }}</li>@endif
    </ul>

    <p style="margin-top:20px;">
        Looking for a room? <a href="{{ route('index') }}">Browse accommodations</a> &middot;
        <a href="{{ route('community.index') }}">Visit the community board</a>
    </p>
</div>
@endsection
