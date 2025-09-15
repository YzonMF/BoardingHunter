@extends('auth.logintemp')
@section('content')
<section>
    <h1>Boarding Hunter</h1>
    <h5>Login To Continue</h5>
</section>
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
            <button type="submit" class="submitbtn">Log in
            </button>
            
            <p class="login">
                Don't have an account? <a href="register">Register</a>
            </p>
        </form>
    </section>
@endsection