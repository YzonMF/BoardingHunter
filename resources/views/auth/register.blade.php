@extends('auth.logintemp')
@section('content')
    <header>
        <h1>Boarding Hunter</h1>
        <p>welcome</p>
    </header>
    
    <section class="logincontainer">
        <form>
            <div class="input-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="input your username" required>
            </div>
            
            <div class="input-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="input your email" required>
            </div>
            
            <div class="input-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="input your password" required>
            </div>
            
            <div class="input-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="Room Seeker">Room Seeker</option>
                    <option value="Room Owner">Room Owner</option>
                </select>
            </div>
            
            <button type="submit" class="submitbtn">Register</button>
            
            <p class="login">
                Already have an account? <a href="#">Login</a>
            </p>
        </form>
    </section>
@endsection