@extends('layouts.app')

@section('title','Private Chat')

@section('content')

@php
$partner = $chat->user_one_id == auth()->id()
    ? $chat->userTwo
    : $chat->userOne;

$lastDate = "";
@endphp

<style>

html, body{
    height:100%;
    margin:0;
    overflow:hidden;
}

.chat-container{
    height:100vh;
    display:flex;
    flex-direction:column;
}


.chat-header{
    background:white;
    border-bottom:1px solid #ddd;
    padding:15px 20px;
}

.chat-body{
    flex:1;
    overflow-y:auto;
    overflow-x:hidden;
    background:#f5f5f5;
    padding:20px;
    padding-bottom:100px;
}
.chat-footer{
    position:fixed;
    bottom:0;
    left:0;
    right:0;
    background:white;
    border-top:1px solid #ddd;
    padding:12px;
    z-index:999;
}

.my-message{
    display:flex;
    justify-content:flex-end;
    margin-bottom:15px;
}

.other-message{
    display:flex;
    justify-content:flex-start;
    margin-bottom:15px;
}

.my-bubble{

    background:#0d6efd;
    color:white;
    padding:12px 15px;
    border-radius:20px 20px 5px 20px;
    max-width:70%;

}

.other-bubble{

    background:white;
    padding:12px 15px;
    border-radius:20px 20px 20px 5px;
    border:1px solid #ddd;
    max-width:70%;

}

.chat-time{

    font-size:11px;
    opacity:.8;
    text-align:right;
    margin-top:5px;

}

.date-divider{

    text-align:center;
    margin:20px 0;

}

.date-divider span{

    background:#6c757d;
    color:white;
    padding:5px 12px;
    border-radius:15px;
    font-size:12px;

}

.avatar{

    width:38px;
    height:38px;
    border-radius:50%;
    background:#6c757d;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-right:10px;

}

</style>

<div class="container-fluid p-0">

    {{-- Header --}}
    <div class="chat-header">

        <div class="d-flex align-items-center">

            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                 style="width:50px;height:50px;">

                {{ strtoupper(substr($partner->name,0,1)) }}

            </div>

            <div class="ms-3">

                <h4 class="mb-0">
                    {{ $partner->name }}
                </h4>

                <small class="text-muted">
                    Private Chat
                </small>

            </div>

        </div>

    </div>

    {{-- Messages --}}
    <div id="chatBody" class="chat-body">

        @foreach($chat->messages as $message)

            @php
            $currentDate = $message->created_at->format('Y-m-d');
            @endphp

            @if($lastDate != $currentDate)

                @php
                $lastDate = $currentDate;
                @endphp

                <div class="date-divider">

                    <span>

                        {{ $message->created_at->format('M d, Y') }}

                    </span>

                </div>

            @endif

            @if($message->user_id==auth()->id())

                <div class="my-message">

                    <div class="my-bubble">

                        {{ $message->message }}

                        <div class="chat-time">

                            {{ $message->created_at->format('H:i') }}

                        </div>

                    </div>

                </div>

            @else

                <div class="other-message">

                    <div class="avatar">

                        {{ strtoupper(substr($partner->name,0,1)) }}

                    </div>

                    <div class="other-bubble">

                        <strong>

                            {{ $partner->name }}

                        </strong>

                        <br>

                        {{ $message->message }}

                        <div class="chat-time text-muted">

                            {{ $message->created_at->format('H:i') }}

                        </div>

                    </div>

                </div>

            @endif

        @endforeach

    </div>

</div>

{{-- Footer --}}
<div class="chat-footer">

   <div class="card-footer bg-white">

        <form action="{{ route('chat.send',$chat) }}"
              method="POST">

            @csrf

            <div class="input-group">

                <input
                    type="text"
                    name="message"
                    class="form-control"
                    placeholder="Type a message..."
                    autocomplete="off"
                    required>

                 <button class="btn btn-primary">

                        Send

                    </button>

            </div>

        </form>

    </div>

</div>
<script>

const body=document.getElementById("chatBody");

body.scrollTop=body.scrollHeight;

</script>

@endsection