@extends('layouts.admin')

@section('title', 'Edit User - Boarding Hunter Admin')

@section('styles')
<style>
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 0 15px;
    }
    .form-container {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="form-container">
        <h1 class="mb-4">Edit User</h1>
        
        <form action="{{ route('users.update', $user->UserID) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" 
                               value="{{ old('fullname', $user->fullname) }}" required>
                        @error('fullname')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="contactnum" class="form-label">Contact Number *</label>
                        <input type="text" class="form-control" id="contactnum" name="contactnum" 
                               value="{{ old('contactnum', $user->contactnum) }}" required>
                        @error('contactnum')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <p><strong>Role:</strong> 
                            <span class="badge {{ $user->Role === 'roomOwner' ? 'bg-success' : 'bg-info' }}">
                                {{ $user->Role }}
                            </span>
                        </p>
                    </div>
                    
                    @if($user->Role === 'roomOwner' && $user->owner)
                        <div class="mb-3">
                            <label for="BusinessName" class="form-label">Business Name</label>
                            <input type="text" class="form-control" id="BusinessName" name="BusinessName" 
                                   value="{{ old('BusinessName', $user->owner->BusinessName) }}">
                        </div>
                    @endif
                    
                    @if($user->Role === 'roomSeeker' && $user->seeker)
                        <div class="mb-3">
                            <label for="Preferences" class="form-label">Preferences</label>
                            <input type="text" class="form-control" id="Preferences" name="Preferences" 
                                   value="{{ old('Preferences', $user->seeker->Preferences) }}">
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection