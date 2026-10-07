@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create New User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/users" method="POST" class="justify-content-center">
        @csrf
      <div class="mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}" required>
      </div>
        
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
      </div>

      <div class="mb-3">
        <label for="contactnum" class="form-label">Contact Number</label>
        <input type="text" class="form-control" id="contactnum" name="contactnum" value="{{ old('contactnum') }}" required>
      </div>

      <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" name="role" id="role" aria-label="Select role" required>
              <option selected disabled>Select Role</option>
              <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="roomOwner" {{ old('role') == 'roomOwner' ? 'selected' : '' }}>Room Owner</option>
              <option value="roomSeeker" {{ old('role') == 'roomSeeker' ? 'selected' : '' }}>Room Seeker</option>
          </select>
      </div>
      <input type="submit" value="Create User" class="btn btn-primary">
      <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection
