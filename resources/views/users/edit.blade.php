@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit {{ $user->fullname }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user) }}" method="POST" class="justify-content-center">
        @csrf
        @method('PUT')

      <div class="mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', $user->fullname) }}" required>
      </div>
        
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
      </div>

      <div class="mb-3">
        <label for="contactnum" class="form-label">Contact Number</label>
        <input type="text" class="form-control" id="contactnum" name="contactnum" value="{{ old('contactnum', $user->contactnum) }}" required>
      </div>

      <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" name="role" id="role" aria-label="Select role" required>
              @foreach(\App\Models\User::ROLES as $value => $label)
                  <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
          </select>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
        <input type="password" class="form-control" id="password" name="password">
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
      </div>

      <input type="submit" value="Save Changes" class="btn btn-primary">
      <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection
