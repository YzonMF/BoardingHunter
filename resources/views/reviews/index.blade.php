@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Reviews
                        <a href="{{ route('reviews.create') }}" class="btn btn-primary float-end">Add Review</a>
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Seeker</th>
                                    <th>Accommodation</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Review Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td>{{ $review->ReviewID }}</td>
                                        <td>{{ $review->seeker->user->name ?? 'N/A' }}</td>
                                        <td>{{ $review->accommodation->Name ?? 'N/A' }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="fa fa-star {{ $i <= $review->Rating ? 'text-warning' : 'text-muted' }}"></span>
                                            @endfor
                                        </td>
                                        <td>{{ Str::limit($review->Comment, 50) }}</td>
                                        <td>{{ $review->ReviewDate->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('reviews.show', $review) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('reviews.edit', $review) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No reviews found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
