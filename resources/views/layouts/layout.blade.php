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
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('inquiries.show') }}" class="{{ request()->routeIs('inquiries.show') ? 'active' : '' }}">Inquiries</a>
                <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
            </div>

            <!-- Hamburger always visible -->
            <div class="hamburger" onclick="toggleMenu()">☰</div>
        </div>

        <!-- Dropdown menu (contains quick + minor links) -->
        <div class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('inquiries.show') }}" class="{{ request()->routeIs('inquiries.show') ? 'active' : '' }}">Inquiries</a>
            <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
            <a href="#">Contact Us</a>
            <a href="#">About Us</a>
            <a href="#">Logout</a>
        </div>
    </header>

    @yield('content')

    <footer>
        <h2>contact us</h2>
        <p>email: boardingHunt@gmail.com</p>
        <p>&copy; Boarding Hunter. All rights reserved.</p>
    </footer>
</body>
</html>
