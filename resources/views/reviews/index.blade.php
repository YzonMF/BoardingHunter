@extends('layouts.layout')

@section('content')
<h1>Reviews</h1>
<a href="{{ route('reviews.create') }}">Create New Review</a>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
<table>
    <thead>
        <tr>
            <th>ReviewID</th>
            <th>Seeker</th>
            <th>Accommodation</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>ReviewDate</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reviews as $review)
        <tr>
            <td>{{ $review->ReviewID }}</td>
            <td>{{ $review->seeker->name ?? 'N/A' }}</td>
            <td>{{ $review->accommodation->name ?? 'N/A' }}</td>
            <td>{{ $review->Rating }}</td>
            <td>{{ $review->Comment }}</td>
            <td>{{ $review->ReviewDate }}</td>
            <td>
                <a href="{{ route('reviews.show', $review) }}">Show</a>
                <a href="{{ route('reviews.edit', $review) }}">Edit</a>
                <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
