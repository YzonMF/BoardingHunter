@extends('layouts.admin')

@section('title', 'User Details - Boarding Hunter Admin')
@section('content')
<div>
    <h5>{{ $user->fullname }}</h5>
    <p><strong>User ID:</strong> {{ $user->UserID }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Contact Number:</strong> {{ $user->contactnum }}</p>
</div>
<div>
    <a href="{{ route('users.edit', $user) }}">Edit User</a>
</div>

<!-- delete-user -->
<form action="{{ route('users.destroy', $user) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Delete User</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection