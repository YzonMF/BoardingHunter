@extends('auth.logintemp')
@section('content')
<header>
    <p>Forgot Your Password?</p>
</header>
<section class="logincontainer">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <p>Enter the email you registered with and we will send you a link to choose a new password.</p>

        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="input your email" value="{{ old('email') }}" required>
        </div>

        <button type="submit" class="submitbtn">Send reset link</button>

        <p class="login"><a href="{{ route('login') }}">Back to login</a></p>
    </form>
</section>
@endsection
