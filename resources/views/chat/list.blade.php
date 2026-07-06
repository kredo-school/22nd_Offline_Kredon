@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">

        Messages

    </h2>

    @forelse($chats as $chat)

        @php

            $partner = $chat->user_one_id == auth()->id()
                ? $chat->userTwo
                : $chat->userOne;

            $lastMessage = $chat->messages->sortByDesc('created_at')->first();

        @endphp

        <a href="{{ route('chat.show',$chat) }}"
           class="text-decoration-none">

            <div class="card border-0 shadow-sm mb-3">

                <div class="card-body d-flex align-items-center">

                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3"
                         style="width:55px;height:55px;font-size:22px;">

                        {{ strtoupper(substr($partner->name,0,1)) }}

                    </div>

                    <div class="flex-grow-1">

                        <div class="d-flex justify-content-between">

                            <strong>

{{ $partner->name }}

@if($chat->unreadCount()>0)

<span class="badge bg-danger">

{{ $chat->unreadCount() }}

</span>

@endif

                            </strong>

                            @if($lastMessage)

                                <small class="text-muted">

                                    {{ $lastMessage->created_at->diffForHumans() }}

                                </small>

                            @endif

                        </div>

                        @if($lastMessage)

                            <div class="text-muted">

                                {{ Str::limit($lastMessage->message,35) }}

                            </div>

                        @endif

                    </div>

                    @if($chat->unread_count)

                        <span class="badge bg-danger rounded-pill ms-3">

                            {{ $chat->unread_count }}

                        </span>

                    @endif

                </div>

            </div>

        </a>

    @empty

        <div class="alert alert-secondary">

            No Chats Yet

        </div>

    @endforelse

</div>

@endsection