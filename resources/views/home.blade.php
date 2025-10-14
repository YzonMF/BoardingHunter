@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<section class="search-filter">
    <div class="search">
        <div >
            <!-- search with text-->
            <input type="text" placeholder="input search" id="text-search">
        </div>
        <button type="submit">search</button>
    </div>
    <div class="filter">
        <div>
            <!-- select location-->
            <label for="location-drop">Location</label>
            <select name="location-drop" id="location-drop"></select>
        </div>
        <div>
            <!-- select capacity-->
            <label for="room-cap">Room Capacity</label>
            <select name="room-cap" id="room-cap">
                <option value="1-person">1-person</option>
                <option value="2-person">2-person</option>
            </select>
            
        </div>
        <div>
            <!-- select type-->
            <label for="type-accomodation">Accomodation</label>
            <select name="type-accomodation" id="type-accomodation">
                <option value="Hotel">Hotel</option>
                <option value="Transient">Transient</option>
                <option value="Boarding">Boarding</option>
            </select>
        </div>
        <button type="submit">Apply</button>        
        
    </div>    

</section>
<section class="home-content">
        <div class="rooms">
            <img src="" alt="room photo" id="room-photo">
            <p id="accomodation type">hotel</p>
            <p id="capacity">max capacity</p>
            <p id="price">price per night: </p>
            <p id="status">available</p>
            <a href="">View details</a>
        </div>
</section>

@endsection