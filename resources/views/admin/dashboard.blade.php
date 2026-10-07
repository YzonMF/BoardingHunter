@extends('layouts.admin')

@section('title', 'Admin Dashboard - ' . $site['site_name'])

@section('styles')
<style>
    .container { max-width: 1200px; margin: 20px auto; padding: 0 15px; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; border-left: 4px solid #2c3e50; }
    .stat-number { font-size: 2.2rem; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
    .stat-label { color: #7f8c8d; font-size: .9rem; text-transform: uppercase; letter-spacing: 1px; }
    .quick-actions { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 30px; }
    .action-buttons { display: flex; gap: 15px; flex-wrap: wrap; }
</style>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card"><div class="stat-number">{{ $usersByRole->sum() }}</div><div class="stat-label">Users</div>
            <small>{{ $usersByRole['roomOwner'] ?? 0 }} owners &middot; {{ $usersByRole['roomSeeker'] ?? 0 }} seekers &middot; {{ $usersByRole['admin'] ?? 0 }} admins</small></div>
        <div class="stat-card"><div class="stat-number">{{ $listingCount }}</div><div class="stat-label">Listings</div></div>
        <div class="stat-card"><div class="stat-number">{{ $pendingRequests }}</div><div class="stat-label">Pending requests</div></div>
        <div class="stat-card"><div class="stat-number">{{ $activeReservations }}</div><div class="stat-label">Active reservations</div></div>
        <div class="stat-card"><div class="stat-number">{{ $confirmedBookings }}</div><div class="stat-label">Confirmed bookings</div></div>
    </div>

    <div class="quick-actions">
        <h3 class="mb-3">Quick Actions</h3>
        <div class="action-buttons">
            <a href="{{ route('users.index') }}" class="btn btn-primary btn-lg">Manage Users</a>
            <a href="{{ route('admin.listings') }}" class="btn btn-primary btn-lg">Manage Listings</a>
            <a href="{{ route('admin.reports') }}" class="btn btn-outline-primary btn-lg">Reports</a>
            <a href="{{ route('community.index') }}" class="btn btn-outline-secondary btn-lg">Community</a>
            <a href="{{ route('index') }}" class="btn btn-outline-secondary btn-lg">View Main Site</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-primary text-white"><h5 class="mb-0">Newest users</h5></div>
                <ul class="list-group list-group-flush">
                    @forelse($recentUsers as $u)
                        <li class="list-group-item">{{ $u->fullname }} <small class="text-muted">({{ $u->role }}) &middot; {{ $u->created_at->diffForHumans() }}</small></li>
                    @empty
                        <li class="list-group-item text-muted">No users yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-info text-white"><h5 class="mb-0">Recent bookings</h5></div>
                <ul class="list-group list-group-flush">
                    @forelse($recentBookings as $b)
                        <li class="list-group-item">
                            {{ $b->seeker->fullname ?? 'Former user' }} &rarr; {{ $b->accommodation->Name ?? 'Removed listing' }}
                            <small class="text-muted">({{ $b->Status }})</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No bookings yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white"><h5 class="mb-0">Latest community posts</h5></div>
                <ul class="list-group list-group-flush">
                    @forelse($recentPosts as $p)
                        <li class="list-group-item">
                            <a href="{{ route('community.show', $p->PostID) }}">{{ $p->Title }}</a>
                            <small class="text-muted">by {{ $p->author->fullname ?? 'Former user' }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No posts yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
