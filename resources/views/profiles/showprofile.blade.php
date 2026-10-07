@extends('layouts.layout')

@section('title', 'My Profile - Boarding Hunter')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">My Profile</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ Auth::user()->fullname }}</h4>
            <span class="badge bg-{{ Auth::user()->role === 'admin' ? 'danger' : (Auth::user()->role === 'roomOwner' ? 'primary' : 'success') }} fs-6">
                {{ Auth::user()->role }}
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Contact Number:</strong> {{ Auth::user()->contactnum }}</p>
                    <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
                    <p><strong>Member since:</strong> {{ Auth::user()->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
