@extends('layouts.admin')

@section('title', 'All Users - ' . $site['site_name'] . ' Admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Users</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>UserID</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Contact Number</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->UserID }}</td>
                    <td><a href="{{ route('users.show', $user->UserID) }}">{{ $user->fullname }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contactnum }}</td>
                    <td>
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'roomOwner' ? 'primary' : 'success') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->UserID) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('users.destroy', $user->UserID) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add User</a>
    </div>
</div>
@endsection
