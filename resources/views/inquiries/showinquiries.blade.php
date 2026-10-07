@extends('layouts.layout')
@section('title', 'Inquiries')

{{-- Different CSS for this page --}}
@section('styles')
<link rel="stylesheet" href="{{ asset('css/inquiries.css') }}">
@endsection

@section('content')
@php $isOwner = Auth::user()->role === 'roomOwner'; @endphp

<div class="inquiries-container">
    <!-- Left Sidebar -->
    <aside class="people">
        <h2>Inquiries</h2>
        <ul class="chat-list">
            @forelse($inquiries as $inquiry)
                <li class="chat {{ $selected && $selected->InquiryID === $inquiry->InquiryID ? 'active' : '' }}">
                    <a href="{{ route('inquiries.show', ['id' => $inquiry->InquiryID]) }}" style="color:inherit; text-decoration:none; display:block;">
                        {{ $isOwner ? $inquiry->seeker->fullname : $inquiry->accommodation->Name }}
                        <br>
                        <small>
                            {{ $isOwner ? $inquiry->accommodation->Name : $inquiry->owner->fullname }}
                            &middot; {{ $inquiry->Status }}
                        </small>
                    </a>
                </li>
            @empty
                <li class="chat">No inquiries yet.</li>
            @endforelse
        </ul>
    </aside>

    <!-- Chat Window -->
    <main class="chat-window">
        @if(session('success'))
            <div style="padding:8px 12px; background:#d1e7dd;">{{ session('success') }}</div>
        @endif

        @if($selected)
            <div class="messages">
                <div class="message {{ $isOwner ? 'received' : 'sent' }}">
                    {{ $selected->Message }}
                    <br><small>{{ $selected->DateSent->format('M d, Y h:i A') }}</small>
                </div>

                @if($selected->Reply)
                    <div class="message {{ $isOwner ? 'sent' : 'received' }}">
                        {{ $selected->Reply }}
                        <br><small>{{ $selected->RepliedAt->format('M d, Y h:i A') }}</small>
                    </div>
                @else
                    <div class="message received" style="opacity:.7;">
                        {{ $isOwner ? 'You have not replied yet.' : 'Waiting for the owner to reply.' }}
                    </div>
                @endif
            </div>

            @if($isOwner && !$selected->Reply)
                <form class="chat-input" action="{{ route('inquiries.reply', $selected->InquiryID) }}" method="POST">
                    @csrf
                    <input type="text" name="Reply" placeholder="Write a reply" maxlength="1000" required>
                    <button type="submit">Send</button>
                </form>
                @error('Reply') <div style="color:#b00; padding:4px 12px;">{{ $message }}</div> @enderror
            @endif
        @else
            <div class="messages">
                <div class="message received">
                    {{ $isOwner
                        ? 'No one has messaged you yet.'
                        : 'You have not contacted any owner yet. Open a room and use "Contact Owner".' }}
                </div>
            </div>
        @endif
    </main>

    <!-- Right Sidebar -->
    <aside class="chat-info">
        @if($selected)
            <h3>{{ $isOwner ? 'Seeker' : 'Owner' }}</h3>
            <p><strong>Name:</strong> {{ $isOwner ? $selected->seeker->fullname : $selected->owner->fullname }}</p>
            <p><strong>Contact:</strong> {{ $isOwner ? $selected->seeker->contactnum : $selected->owner->contactnum }}</p>
            <p><strong>Status:</strong> {{ $selected->Status }}</p>
            <p><strong>Room:</strong>
                <a href="{{ route('accommodations.show', $selected->AccommodationID) }}">{{ $selected->accommodation->Name }}</a>
            </p>
        @endif
    </aside>
</div>
@endsection
