@extends('layouts.admin')

@section('title', 'All Users - Boarding Hunter Admin')

@section('content')
<h1>Users</h1>
    <table>
        <thead>
            <tr>
                <th>UserID</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Contact Number</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><a href="{{ route('users.show', $user->UserID) }}">{{ $user->UserID }}</a></td>
                    <td><a href="{{ route('users.show', $user->UserID) }}">{{ $user->fullname }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contactnum }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <a href="/users/create">Add User</a>
    </div>
@endsection
