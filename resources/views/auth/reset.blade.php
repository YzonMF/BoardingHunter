@extends('auth.logintemp')
@section('content')
<header>
    <p>Choose a New Password</p>
</header>
<section class="logincontainer">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required>
        </div>

        <div class="input-group">
            <label for="password">New password <small>(at least 8 characters)</small></label>
            <input id="password" name="password" type="password" required autocomplete="new-password">
        </div>

        <div class="input-group">
            <label for="password_confirmation">Confirm new password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">
        </div>

        <button type="submit" class="submitbtn">Reset password</button>

        <p class="login"><a href="{{ route('login') }}">Back to login</a></p>
    </form>
</section>
@endsection
