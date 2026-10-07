@extends('auth.logintemp')
@section('content')
<header>
    <p>Login To Continue</p>
</header>
<section class="logincontainer">
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

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="input-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="input your email" value="{{ old('email') }}" required>
        </div>
        
        <div class="input-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="input your password" required>
        </div>

        <div class="input-group">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>

        <button type="submit" class="submitbtn">Log in</button>
        
        <p class="login">
            Don't have an account? <a href="/register">Register</a>
        </p>

        <p class="login">
            <a href="/forgotpassword">Forgot Password?</a>
        </p>
    </form>
</section>
@endsection