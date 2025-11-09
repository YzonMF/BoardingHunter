@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create New Accommodation</h1>

    <form action="/accommodation" method="POST" class=" justify-content-center">
        @csrf
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">AccommodationID</label>
        <input type="text" class="form-control" id="input" name="accommodationID">
      </div>
        
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input type="text" class="form-control" id="input" name="Name">
      </div>

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Description</label>
        <input type="text" class="form-control" id="input" name="description">
      </div>

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Location</label>
        <input type="text" class="form-control" id="input" name="location">
      </div>

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">PricePerNight</label>
        <input type="text" class="form-control" id="input" name="pricepernight">
      </div>

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">PricePerMonth</label>
        <input type="text" class="form-control" id="input" name="pricepermonth">
      </div>

      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">PhotoID</label>
        <input type="text" class="form-control" id="input" name="PhotoID">
      </div>

      <div class="mb-3">
          <select class="form-select" name="role" aria-label="Select role">
              <option selected disabled>Room Type</option>
              <option value="boarding">Boarding</option>
              <option value="transient">Transient</option>
              <option value="hotel">Hotel</option>
          </select>
      </div>
      <input type="submit" value="Submit">

    </form>
</div>

@endsection

