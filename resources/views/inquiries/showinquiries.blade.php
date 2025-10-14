@extends('layouts.layout')
@section('title', 'Inquiries')

{{-- Different CSS for this page --}}
@section('styles')
<link rel="stylesheet" href="{{ asset('css/inquiries.css') }}">
@endsection

@section('content')
<div class="inquiries-container">
    <!-- Left Sidebar -->
    <aside class="people">
        <h2>Inqiuries</h2>
        <input type="text" placeholder="Search inquiry">
        <ul class="chat-list">
            <li class="chat active">Sir Balmond Dagus</li>
            <li class="chat">ITP317 System Integration</li>
            <li class="chat">Alucard</li>
            <li class="chat">Badang</li>
            <li class="chat">Gloo</li>
        </ul>
    </aside>

    <!-- Chat Window -->
    <main class="chat-window">
        <div class="messages">
            <div class="message received">Hello, how are you?</div>
            <div class="message sent">I'm good, thanks! How about you?</div>
            <div class="message received">Doing well, thanks for asking!</div>
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Aa">
            <button>Send</button>
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="chat-info">
        <h3>User Info</h3>
        <p><strong>Name:</strong>Sir Balmond Dagus</p>
        <p><strong>Status:</strong> Online</p>
        <ul>
            <li>Profile</li>
            <li>Mute</li>
            <li>Search</li>
        </ul>
    </aside>
</div>
@endsection
