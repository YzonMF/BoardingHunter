@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit {{ $user->fullname }}</h1>

    <form action="{{ route('users.update', $user) }}" method="POST" class=" justify-content-center">
        @csrf
        @method('PUT')

      <div class="mb-3">
        <input type="text" class="form-control" id="input" name="fullname" placeholder="{{$user->fullname }}">
      </div>
        
      <div class="mb-3">
        <input type="email" class="form-control" id="input" name="email" placeholder="{{ $user->email }}">
      </div>

      <div class="mb-3">
        <input type="text" class="form-control" id="input" name="contactnum" placeholder="{{ $user->contactnum }}">
      </div>

      <div class="mb-3">
          <select class="form-select" name="role" aria-label="Select role">
              <option selected disabled>{{ $user->role }}</option>
              <option value="admins">Admin</option>
              <option value="roomOwner">Room Owner</option>
              <option value="roomSeeker">Room Seeker</option>
          </select>
      </div>
      <input type="submit" value="Save">

    </form>
</div>

@endsection
