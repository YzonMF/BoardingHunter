@extends('layouts.admin')

@section('title', 'User Details - Boarding Hunter Admin')

@section('styles')
<style>
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 0 15px;
    }
    .user-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="user-card">
        <div class="card-header bg-dark text-white">
            <h5 class="card-title mb-0">{{ $user->fullname }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>User ID:</strong> {{ $user->UserID }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Contact Number:</strong> {{ $user->contactnum }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Role:</strong> 
                        <span class="badge {{ $user->Role === 'roomOwner' ? 'bg-success' : 'bg-info' }}">
                            {{ $user->Role }}
                        </span>
                    </p>
                    <p><strong>Date Joined:</strong> {{ $user->dateJoined->format('M d, Y H:i') }}</p>
                    
                    @if($user->Role === 'roomOwner' && $user->owner)
                        <p><strong>Business Name:</strong> {{ $user->owner->BusinessName }}</p>
                    @endif
                    
                    @if($user->Role === 'roomSeeker' && $user->seeker)
                        <p><strong>Preferences:</strong> {{ $user->seeker->Preferences ?? 'None' }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('users.edit', $user->UserID) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection