@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Review
                        <a href="{{ route('reviews.index') }}" class="btn btn-secondary float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="SeekerID" class="form-label">Seeker</label>
                            <select name="SeekerID" id="SeekerID" class="form-control @error('SeekerID') is-invalid @enderror" required>
                                <option value="">Select Seeker</option>
                                @foreach($seekers as $seeker)
                                    <option value="{{ $seeker->UserID }}" {{ old('SeekerID') == $seeker->UserID ? 'selected' : '' }}>
                                        {{ $seeker->user->name ?? 'User ' . $seeker->UserID }}
                                    </option>
                                @endforeach
                            </select>
                            @error('SeekerID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="AccommodationID" class="form-label">Accommodation</label>
                            <select name="AccommodationID" id="AccommodationID" class="form-control @error('AccommodationID') is-invalid @enderror" required>
                                <option value="">Select Accommodation</option>
                                @foreach($accommodations as $accommodation)
                                    <option value="{{ $accommodation->AccommodationID }}" {{ old('AccommodationID') == $accommodation->AccommodationID ? 'selected' : '' }}>
                                        {{ $accommodation->Name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('AccommodationID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Rating" class="form-label">Rating</label>
                            <select name="Rating" id="Rating" class="form-control @error('Rating') is-invalid @enderror" required>
                                <option value="">Select Rating</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('Rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            @error('Rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Comment" class="form-label">Comment</label>
                            <textarea name="Comment" id="Comment" class="form-control @error('Comment') is-invalid @enderror" rows="4" placeholder="Enter your review comment...">{{ old('Comment') }}</textarea>
                            @error('Comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Create Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
