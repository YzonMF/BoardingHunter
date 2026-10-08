<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $site['site_name'] . ' - Admin')</title>

    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/menu.js') }}"></script>

    <!-- Page-specific CSS -->
    @yield('styles')
</head>
<body>
    <header>
        <div class="navbar">
            <h1>{{ $site['site_name'] }} - Admin Panel</h1>

            <!-- Quick access links (shown only on wide screens) -->
            <div class="quick-links">
                <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Main Site</a>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.index') ? 'active' : '' }}">Manage Users</a>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.listings') }}" class="{{ request()->routeIs('admin.listings*') ? 'active' : '' }}">Listings</a>
                <a href="{{ route('admin.room-types') }}" class="{{ request()->routeIs('admin.room-types*') ? 'active' : '' }}">Room Types</a>
                <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>
                <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">Settings</a>
                <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
            </div>

            <!-- Hamburger always visible -->
            <div class="hamburger" onclick="toggleMenu()">☰</div>
        </div>

        <!-- Dropdown menu (contains quick + minor links) -->
        <div class="nav-links">
            <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Main Site</a>
            <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.index') ? 'active' : '' }}">Manage Users</a>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.listings') }}" class="{{ request()->routeIs('admin.listings*') ? 'active' : '' }}">Listings</a>
            <a href="{{ route('admin.room-types') }}" class="{{ request()->routeIs('admin.room-types*') ? 'active' : '' }}">Room Types</a>
            <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">Reports</a>
            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">Settings</a>
            <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.show') ? 'active' : '' }}">Profile</a>
            <a href="{{ route('community.index') }}">Community</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;font:inherit;padding:inherit;">Logout</button>
            </form>
        </div>
    </header>

    @yield('content')

    <footer>
        <h2>Admin Panel</h2>
        <p>{{ $site['site_name'] }} Administration System</p>
        <p>&copy; {{ $site['site_name'] }}. All rights reserved.</p>
    </footer>
</body>
</html>