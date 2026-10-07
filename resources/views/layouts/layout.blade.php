<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $site['site_name'])</title>

    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <script src="{{ asset('js/menu.js') }}"></script>

    <!-- Page-specific CSS -->
    <style>.pagination{display:flex;gap:6px;list-style:none;padding:0;flex-wrap:wrap}.pagination li{padding:4px 8px;border:1px solid #ddd;border-radius:4px}.pagination .active{background:#eef5ff;font-weight:bold}</style>
    @yield('styles')
</head>
<body>
    @auth
        @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
    @endauth
    <header>
        <div class="navbar">
            <h1>{{ $site['site_name'] }}</h1>

            <!-- Quick access links (shown only on wide screens) -->
            <div class="quick-links">
                <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
                <a href="{{ route('community.index') }}" class="{{ request()->routeIs('community.*') ? 'active' : '' }}">Community</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
                @auth
                    <a href="{{ route('inquiries.show') }}" class="{{ request()->routeIs('inquiries.show') ? 'active' : '' }}">Inquiries</a>
                    <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">Reservations</a>
                    <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">Bookings</a>
                    <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">Notifications {{ $unreadCount > 0 ? '(' . $unreadCount . ')' : '' }}</a>
                    <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
                @endauth
            </div>

            <!-- Hamburger always visible -->
            <div class="hamburger" onclick="toggleMenu()">☰</div>
        </div>

        <!-- Dropdown menu (contains quick + minor links) -->
        <div class="nav-links">
            <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
            <a href="{{ route('community.index') }}" class="{{ request()->routeIs('community.*') ? 'active' : '' }}">Community</a>
            @auth
                <a href="{{ route('inquiries.show') }}" class="{{ request()->routeIs('inquiries.show') ? 'active' : '' }}">Inquiries</a>
                <a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">Reservations</a>
                <a href="{{ route('bookings.index') }}" class="{{ request()->routeIs('bookings.*') ? 'active' : '' }}">Bookings</a>
                <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">Notifications {{ $unreadCount > 0 ? '(' . $unreadCount . ')' : '' }}</a>
                <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
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
        <h2><a href="{{ route('contact') }}" style="color:inherit;">Contact Us</a></h2>
        <p>Email: <a href="mailto:{{ $site['contact_email'] }}" style="color:inherit;">{{ $site['contact_email'] }}</a></p>
        @if($site['contact_phone'])<p>Phone: {{ $site['contact_phone'] }}</p>@endif
        @if($site['address'])<p>{{ $site['address'] }}</p>@endif
        <p>&copy; {{ date('Y') }} {{ $site['site_name'] }}. All rights reserved.</p>
    </footer>
</body>
</html>
