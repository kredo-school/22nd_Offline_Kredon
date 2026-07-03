@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Messages
    </h2>

    @foreach($chats as $chat)

        <a href="{{ route('chat.show',$chat->id) }}"
           class="text-decoration-none">

            <div class="card mb-3">

                <div class="card-body">

                    Chat #{{ $chat->id }}

                </div>

            </div>

        </a>

    @endforeach

</div>

@endsection