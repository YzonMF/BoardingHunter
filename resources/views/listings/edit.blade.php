@extends('layouts.layout')

@section('title', 'Edit ' . $accommodation->Name . ' - Boarding Hunter')

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <h2>Edit Listing</h2>

    @if(session('success')) <div style="background:#d1e7dd; padding:8px 12px; margin-bottom:10px;">{{ session('success') }}</div> @endif
    @if(session('error')) <div style="background:#f8d7da; padding:8px 12px; margin-bottom:10px;">{{ session('error') }}</div> @endif

    @if($accommodation->photos->isNotEmpty())
        <h4>Current photos</h4>
        <div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
            @foreach($accommodation->photos as $photo)
                <div style="width:160px;">
                    <img src="{{ $photo->FilePathURL }}" alt="{{ $photo->Caption ?? $accommodation->Name }}"
                         style="width:160px; height:110px; object-fit:cover; border-radius:6px;">
                    <form action="{{ route('listings.photos.destroy', [$accommodation->AccommodationID, $photo->PhotoID]) }}" method="POST"
                          onsubmit="return confirm('Remove this photo?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('listings.update', $accommodation->AccommodationID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('listings._form')

        <p style="margin-top:20px;">
            <button type="submit">Save Changes</button>
            <a href="{{ route('listings.index') }}">Cancel</a>
        </p>
    </form>

    <hr style="margin:28px 0;">
    <h3>Amenities</h3>

    @forelse($accommodation->amenities as $amenity)
        <form action="{{ route('listings.amenities.destroy', [$accommodation->AccommodationID, $amenity->AmenityID]) }}" method="POST"
              style="display:flex; gap:10px; align-items:center; margin-bottom:6px;">
            @csrf
            @method('DELETE')
            <span><strong>{{ $amenity->AmenityName }}</strong>@if($amenity->Description) &mdash; {{ $amenity->Description }}@endif</span>
            <button type="submit">Remove</button>
        </form>
    @empty
        <p>No amenities yet.</p>
    @endforelse

    <form action="{{ route('listings.amenities.store', $accommodation->AccommodationID) }}" method="POST" style="margin-top:12px;">
        @csrf
        <input type="text" name="AmenityName" placeholder="Amenity (e.g. Wi-Fi)" maxlength="100" required value="{{ old('AmenityName') }}">
        <input type="text" name="Description" placeholder="Details (optional)" maxlength="500" value="{{ old('Description') }}">
        <button type="submit">Add amenity</button>
        @error('AmenityName') <div style="color:#b00;">{{ $message }}</div> @enderror
        @error('Description') <div style="color:#b00;">{{ $message }}</div> @enderror
    </form>
</div>
@endsection
