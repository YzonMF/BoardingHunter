@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create New User</h1>

    <form action="/users" method="POST" class=" justify-content-center">
        @csrf
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="input" name="fullname">
      </div>
        
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="input" name="email">
      </div>

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Contact Number</label>
        <input type="text" class="form-control" id="input" name="contactnum">
      </div>

      <div class="mb-3">
          <select class="form-select" name="role" aria-label="Select role">
              <option selected disabled>Select Role</option>
              <option value="admins">Admin</option>
              <option value="roomOwner">Room Owner</option>
              <option value="roomSeeker">Room Seeker</option>
          </select>
      </div>
      <input type="submit" value="Submit">

    </form>
</div>

@endsection
