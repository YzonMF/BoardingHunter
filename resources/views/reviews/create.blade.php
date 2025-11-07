@extends('layouts.layout')

@section('content')
<h1>Create Review</h1>
<form action="{{ route('reviews.store') }}" method="POST">
    @csrf
    <label for="SeekerID">Seeker</label>
    <select name="SeekerID" id="SeekerID" required>
        <option value="">Select Seeker</option>
        @foreach($seekers as $seeker)
            <option value="{{ $seeker->UserID }}">{{ $seeker->name ?? $seeker->UserID }}</option>
        @endforeach
    </select>
    <br>
    <label for="AccommodationID">Accommodation</label>
    <select name="AccommodationID" id="AccommodationID" required>
        <option value="">Select Accommodation</option>
        @foreach($accommodations as $accommodation)
            <option value="{{ $accommodation->AccommodationID }}">{{ $accommodation->name ?? $accommodation->AccommodationID }}</option>
        @endforeach
    </select>
    <br>
    <label for="Rating">Rating</label>
    <input type="number" name="Rating" id="Rating" min="1" max="5" required>
    <br>
    <label for="Comment">Comment</label>
    <textarea name="Comment" id="Comment" rows="3"></textarea>
    <br>
    <button type="submit">Create Review</button>
    <a href="{{ route('reviews.index') }}">Cancel</a>
</form>
@endsection
