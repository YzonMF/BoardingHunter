<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boarding Hunter')</title>

    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <script src="{{ asset('js/menu.js') }}"></script>

    <!-- Page-specific CSS -->
    @yield('styles')
</head>
<body>
    <header>
        <div class="navbar">
            <h1>Boarding Hunter</h1>

            <!-- Quick access links (shown only on wide screens) -->
            <div class="quick-links">
                <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
                @auth
                    <a href="{{ route('inquiries.show') }}" class="{{ request()->routeIs('inquiries.show') ? 'active' : '' }}">Inquiries</a>
                    <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">Reservations</a>
                    <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">Bookings</a>
                    <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
                @endauth
            </div>

            <!-- Hamburger always visible -->
            <div class="hamburger" onclick="toggleMenu()">☰</div>
        </div>

        <!-- Dropdown menu (contains quick + minor links) -->
        <div class="nav-links">
            <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
            @auth
                <a href="{{ route('inquiries.show') }}" class="{{ request()->routeIs('inquiries.show') ? 'active' : '' }}">Inquiries</a>
                <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">Reservations</a>
                <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">Bookings</a>
                <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
                <a href="#">Contact Us</a>
                <a href="#">About Us</a>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;font:inherit;padding:inherit;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register.form') }}">Register</a>
            @endauth
        </div>
    </header>

    @yield('content')

    <footer>
        <h2>Contact Us</h2>
        <p>Email: boardingHunt@gmail.com</p>
        <p>&copy; {{ date('Y') }} Boarding Hunter. All rights reserved.</p>
    </footer>
</body>
</html>
