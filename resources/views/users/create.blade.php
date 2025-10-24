@extends('layouts.admin')

@section('title', 'Add New User - Boarding Hunter Admin')

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
        <h1 class="mb-4">Add New User</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required
                               value="{{ old('fullname') }}">
                        @error('fullname')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="{{ old('email') }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="contactnum" class="form-label">Contact Number *</label>
                        <input type="text" class="form-control" id="contactnum" name="contactnum" required
                               value="{{ old('contactnum') }}">
                        @error('contactnum')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="Role" class="form-label">Role *</label>
                        <select class="form-select" id="Role" name="Role" required>
                            <option value="">Select Role</option>
                            <option value="roomSeeker" {{ old('Role') == 'roomSeeker' ? 'selected' : '' }}>Room Seeker</option>
                            <option value="roomOwner" {{ old('Role') == 'roomOwner' ? 'selected' : '' }}>Room Owner</option>
                        </select>
                        @error('Role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="businessNameField" style="display: none;">
                        <label for="BusinessName" class="form-label">Business Name *</label>
                        <input type="text" class="form-control" id="BusinessName" name="BusinessName"
                               value="{{ old('BusinessName') }}">
                        @error('BusinessName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="preferencesField" style="display: none;">
                        <label for="Preferences" class="form-label">Preferences</label>
                        <input type="text" class="form-control" id="Preferences" name="Preferences"
                               value="{{ old('Preferences') }}">
                        @error('Preferences')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('Role').addEventListener('change', function() {
        const role = this.value;
        const businessField = document.getElementById('businessNameField');
        const preferencesField = document.getElementById('preferencesField');
        
        if (role === 'roomOwner') {
            businessField.style.display = 'block';
            preferencesField.style.display = 'none';
            // Make BusinessName required
            document.getElementById('BusinessName').required = true;
            document.getElementById('Preferences').required = false;
        } else if (role === 'roomSeeker') {
            businessField.style.display = 'none';
            preferencesField.style.display = 'block';
            // Make Preferences optional
            document.getElementById('BusinessName').required = false;
            document.getElementById('Preferences').required = false;
        } else {
            businessField.style.display = 'none';
            preferencesField.style.display = 'none';
            document.getElementById('BusinessName').required = false;
            document.getElementById('Preferences').required = false;
        }
    });

    // Trigger change event on page load to show/hide fields based on selected role
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('Role');
        const oldRole = "{{ old('Role') }}";
        
        if (oldRole) {
            roleSelect.value = oldRole;
            roleSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection