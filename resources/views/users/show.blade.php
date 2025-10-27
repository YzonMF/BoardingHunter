@extends('layouts.admin')

@section('title', 'User Details - Boarding Hunter Admin')
@section('content')
<div>
    <h5>{{ $user->fullname }}</h5>
    <p><strong>User ID:</strong> {{ $user->UserID }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Contact Number:</strong> {{ $user->contactnum }}</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection