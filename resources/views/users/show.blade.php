@extends('layouts.admin')

@section('title', $user->fullname . ' - User Details - Boarding Hunter Admin')

@section('content')
<div class="container mt-4">
    <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">&larr; Back to Users</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">{{ $user->fullname }}</h3>
            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'roomOwner' ? 'primary' : 'success') }} fs-6">
                {{ $user->role }}
            </span>
        </div>
        <div class="card-body">
            <p><strong>User ID:</strong> {{ $user->UserID }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Contact Number:</strong> {{ $user->contactnum }}</p>
            <p><strong>Created:</strong> {{ $user->created_at }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Edit User</a>

            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete User</button>
            </form>
        </div>
    </div>
</div>

@endsection