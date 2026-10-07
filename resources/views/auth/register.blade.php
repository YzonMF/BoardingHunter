@extends('auth.logintemp')
@section('content')
        <p>welcome</p>
        <p>Register to Continue</p>
<section class="logincontainer">
<form action="{{ route('register') }}" method="POST" class="justify-content-center">
    @csrf
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
        <select class="form-select" name="role" aria-label="Select role" required>
            <option selected disabled>Select Role</option>
            @foreach(\App\Models\User::PUBLIC_ROLES as $role)
                <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>{{ \App\Models\User::ROLES[$role] }}</option>
            @endforeach
        </select>
    </div>

    <input type="submit" value="Register">
    <a href="/login">already have an account?</a>
</form>
</section>
@endsection