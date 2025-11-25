@extends('layouts.admin')

@section('title', 'Admin Dashboard - Boarding Hunter')

@section('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 0 15px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        border-left: 4px solid #2c3e50;
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    .stat-label {
        color: #7f8c8d;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .quick-actions {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>
    
    
    <div class="quick-actions">
        <h3 class="mb-3">Quick Actions</h3>
        <div class="action-buttons">
            <a href="{{ route('users.index') }}" class="btn btn-primary btn-lg">Manage Users</a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">View Main Site</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <p>User management system is ready. You can:</p>
                    <ul>
                        <li>View all users</li>
                        <li>Edit existing users</li>
                        <li>Delete users</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">System Information</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection