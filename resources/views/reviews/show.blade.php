@extends('layouts.layout')

@section('content')
<h1>Review Details</h1>
<p><strong>Review ID:</strong> {{ $review->ReviewID }}</p>
<p><strong>Seeker:</strong> {{ $review->seeker->name ?? 'N/A' }}</p>
<p><strong>Accommodation:</strong> {{ $review->accommodation->name ?? 'N/A' }}</p>
<p><strong>Rating:</strong> {{ $review->Rating }}/5</p>
<p><strong>Comment:</strong> {{ $review->Comment ?: 'No comment' }}</p>
<p><strong>Review Date:</strong> {{ $review->ReviewDate }}</p>
<a href="{{ route('reviews.index') }}">Back to Reviews</a>
<a href="{{ route('reviews.edit', $review) }}">Edit</a>
@endsection
