@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Review Details
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary float-end">Back</a>
                        <a href="{{ route('reviews.edit', $review) }}" class="btn btn-warning float-end me-2">Edit</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Review Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th>Review ID:</th>
                                    <td>{{ $review->ReviewID }}</td>
                                </tr>
                                <tr>
                                    <th>Seeker:</th>
                                    <td>{{ $review->seeker->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Accommodation:</th>
                                    <td>{{ $review->accommodation->Name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Rating:</th>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="fa fa-star {{ $i <= $review->Rating ? 'text-warning' : 'text-muted' }}"></span>
                                        @endfor
                                        ({{ $review->Rating }}/5)
                                    </td>
                                </tr>
                                <tr>
                                    <th>Review Date:</th>
                                    <td>{{ $review->ReviewDate->format('F d, Y \a\t g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Comment</h5>
                            <div class="border p-3 rounded">
                                @if($review->Comment)
                                    <p>{{ $review->Comment }}</p>
                                @else
                                    <p class="text-muted">No comment provided.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
