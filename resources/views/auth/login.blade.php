@extends('auth.logintemp')
@section('content')
<header>
    <p>Login To Continue</p>
</header>
<section class="logincontainer">
        <form action="/boardinghunter/home">

            <div class="input-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="input your email" >
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="input your password" >
            </div>
            <button type="submit" class="submitbtn">Log in</button>
            
            <p class="login">
                Don't have an account? <a href="register">Register</a>
            </p>
        </form>
    </section>
@endsection