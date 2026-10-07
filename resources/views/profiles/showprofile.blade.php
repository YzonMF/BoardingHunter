@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.layout')

@section('title', 'My Profile - Boarding Hunter')

@section('content')
<div style="max-width:800px; margin:20px auto; padding:0 16px;">
    <h2>My Profile</h2>

    @if (session('success'))
        <div style="background:#d1e7dd; padding:8px 12px; margin-bottom:12px;">{{ session('success') }}</div>
    @endif

    <p>
        <strong>Role:</strong>
        {{ ['admin' => 'Admin', 'roomOwner' => 'Room Owner', 'roomSeeker' => 'Room Seeker'][$user->role] ?? $user->role }}
        &middot; <strong>Member since:</strong> {{ $user->created_at->format('M d, Y') }}
    </p>

    <style>
        .profile-form label { display:block; margin-top:12px; font-weight:bold; }
        .profile-form input { width:100%; padding:8px; box-sizing:border-box; }
        .profile-form .err { color:#b00; font-size:14px; }
        .profile-card { border:1px solid #ddd; border-radius:6px; padding:16px; margin-bottom:24px; }
    </style>

    <div class="profile-card">
        <h4>Details</h4>
        <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
            @csrf
            @method('PUT')

            <label for="fullname">Full name</label>
            <input type="text" id="fullname" name="fullname" maxlength="50" required value="{{ old('fullname', $user->fullname) }}">
            @error('fullname') <div class="err">{{ $message }}</div> @enderror

            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="50" required value="{{ old('email', $user->email) }}">
            @error('email') <div class="err">{{ $message }}</div> @enderror

            <label for="contactnum">Contact number</label>
            <input type="text" id="contactnum" name="contactnum" maxlength="50" required value="{{ old('contactnum', $user->contactnum) }}">
            @error('contactnum') <div class="err">{{ $message }}</div> @enderror

            @if($user->role === 'roomOwner')
                <label for="BusinessName">Business name <small>(shown to seekers on your listings)</small></label>
                <input type="text" id="BusinessName" name="BusinessName" maxlength="100" value="{{ old('BusinessName', $details->BusinessName ?? '') }}">
                @error('BusinessName') <div class="err">{{ $message }}</div> @enderror
            @elseif($user->role === 'roomSeeker')
                <label for="Preferences">Room preferences <small>(e.g. near campus, budget)</small></label>
                <input type="text" id="Preferences" name="Preferences" maxlength="100" value="{{ old('Preferences', $details->Preferences ?? '') }}">
                @error('Preferences') <div class="err">{{ $message }}</div> @enderror
            @endif

            <p style="margin-top:16px;"><button type="submit">Save profile</button></p>
        </form>
    </div>

    <div class="profile-card">
        <h4>Change password</h4>
        <form action="{{ route('profile.password') }}" method="POST" class="profile-form">
            @csrf
            @method('PUT')

            <label for="current_password">Current password</label>
            <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
            @error('current_password') <div class="err">{{ $message }}</div> @enderror

            <label for="password">New password <small>(at least 8 characters)</small></label>
            <input type="password" id="password" name="password" required autocomplete="new-password">
            @error('password') <div class="err">{{ $message }}</div> @enderror

            <label for="password_confirmation">Confirm new password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">

            <p style="margin-top:16px;"><button type="submit">Change password</button></p>
        </form>
    </div>
</div>
@endsection
