@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Reviews</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ReviewID</th>
                <th>SeekerID</th>
                <th>AccommodationID</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>ReviewDate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
            <tr>
                <td>{{ $review->ReviewID }}</td>
                <td>{{ $review->SeekerID }}</td>
                <td>{{ $review->AccommodationID }}</td>
                <td>{{ $review->Rating }}</td>
                <td>{{ $review->Comment }}</td>
                <td>{{ $review->ReviewDate }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
