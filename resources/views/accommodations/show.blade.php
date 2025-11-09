show blade
@extends('layouts.admin')

@section('title', 'Accommodation Details - Boarding Hunter ')
@section('content')
<div>
    <h5>{{ $Accommodation -> accommodationID }}</h5>
    <p><strong>Name:</strong> {{ $Accommodation->Name}}</p>
    <p><strong>Description:</strong> {{ $Accommodation->Description }}</p>
    <p><strong>location:</strong> {{ $Accommodation->Location }}</p>
    <p><strong>PricePerNight:</strong> {{ $Accommodation->PricePerNight }}</p>
    <p><strong>PricePerMonth:</strong> {{ $Accommodation->PricePerMonth }}</p>
    <p><strong>PhotoID:</strong> {{ $Accommodation-> PhotoID}}</p>
    <p><strong>:</strong> {{ $Accommodation-> PhotoID}}</p>

</div>
<div>
    <a href="{{ route('users.edit', $user) }}">Edit User</a>
</div>

<!-- delete-accommodation -->
<form action="{{ route('Accommodation.destroy', $user) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Delete Accommodation</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
