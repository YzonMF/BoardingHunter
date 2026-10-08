@extends('layouts.admin')

@section('title', 'Settings - ' . $site['site_name'])

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 15px;">
    <h1 class="mb-3">Site Settings</h1>
    <p class="text-muted">These values are stored in the database and used across the whole site: page titles, the footer, the About/Contact page, prices and reservation holds.</p>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label" for="site_name">Site name</label>
            <input type="text" class="form-control @error('site_name') is-invalid @enderror" id="site_name" name="site_name" maxlength="100" required value="{{ old('site_name', $settings['site_name']) }}">
            @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="contact_email">Contact email</label>
                <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" maxlength="100" required value="{{ old('contact_email', $settings['contact_email']) }}">
                @error('contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="contact_phone">Contact phone <small class="text-muted">(optional)</small></label>
                <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" maxlength="50" value="{{ old('contact_phone', $settings['contact_phone']) }}">
                @error('contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="address">Address <small class="text-muted">(optional)</small></label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" maxlength="255" value="{{ old('address', $settings['address']) }}">
            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="about_text">About text</label>
            <textarea class="form-control @error('about_text') is-invalid @enderror" id="about_text" name="about_text" rows="5" maxlength="2000">{{ old('about_text', $settings['about_text']) }}</textarea>
            @error('about_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="currency_symbol">Currency symbol</label>
                <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" id="currency_symbol" name="currency_symbol" maxlength="5" required value="{{ old('currency_symbol', $settings['currency_symbol']) }}">
                <div class="form-text">Example: {{ \App\Models\Setting::money(1250) }}</div>
                @error('currency_symbol') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="reservation_hold_days">Reservation hold (days)</label>
                <input type="number" class="form-control @error('reservation_hold_days') is-invalid @enderror" id="reservation_hold_days" name="reservation_hold_days" min="1" max="60" required value="{{ old('reservation_hold_days', $settings['reservation_hold_days']) }}">
                <div class="form-text">How long an owner-approved reservation holds a room. Applies to reservations approved from now on.</div>
                @error('reservation_hold_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <h4 class="mt-4">Display and upload limits</h4>

        <div class="mb-3">
            <label class="form-label" for="home_tagline">Home page tagline <small class="text-muted">(optional)</small></label>
            <input type="text" class="form-control @error('home_tagline') is-invalid @enderror" id="home_tagline" name="home_tagline" maxlength="150" value="{{ old('home_tagline', $settings['home_tagline']) }}">
            @error('home_tagline') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            @foreach([
                ['home_latest_count', 'Latest rooms on the member home page', 1, 24, ''],
                ['posts_per_page', 'Community posts per page', 5, 50, ''],
                ['max_photos_per_upload', 'Photos per upload', 1, 20, 'How many images an owner can add in one go.'],
                ['max_photo_mb', 'Largest photo (MB)', 1, 10, 'Check this is not above your server\'s upload_max_filesize.'],
            ] as [$key, $label, $min, $max, $help])
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="{{ $key }}">{{ $label }}</label>
                    <input type="number" class="form-control @error($key) is-invalid @enderror" id="{{ $key }}" name="{{ $key }}" min="{{ $min }}" max="{{ $max }}" required value="{{ old($key, $settings[$key]) }}">
                    @if($help)<div class="form-text">{{ $help }}</div>@endif
                    @error($key) <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Save settings</button>
    </form>
</div>
@endsection
