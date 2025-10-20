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
                    <td>{{ $user->UserID }}</td>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->contactnum }}</td>
                    <td>{{ $user->Role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
