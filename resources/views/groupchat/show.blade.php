@extends('layouts.app')

@section('content')

<div class="container">

   
<div class="d-flex justify-content-between align-items-center mb-3">

    <h2>
        {{ $event->title }}
    </h2>

    <a
        href="{{ route('group.chat.members',$event) }}"
        class="btn btn-outline-primary">

        👥 Participants

    </a>

</div>
    <div class="card">

        {{-- Messages --}}
        <div
            id="chatBody"
            class="card-body"
            style="height:500px;overflow-y:auto;">

            @php
                $lastDate = null;
            @endphp

            @forelse($chat->messages as $message)

                {{-- Date --}}
                @if($lastDate != $message->created_at->format('Y-m-d'))

                    @php
                        $lastDate = $message->created_at->format('Y-m-d');
                    @endphp

                    <div class="text-center my-3">

                        <span class="badge bg-secondary">

                            {{ $message->created_at->format('M d, Y') }}

                        </span>

                    </div>

                @endif

                {{-- My message --}}
                @if($message->user_id == auth()->id())

                    <div class="d-flex justify-content-end mb-3">

                        <div
                            class="bg-primary text-white p-3"
                            style="max-width:70%;border-radius:18px 18px 0 18px;">

                            {{ $message->message }}

                            <div
                                class="text-end mt-1"
                                style="font-size:11px;opacity:.8;">

                                {{ $message->created_at->format('H:i') }}

                            </div>

                        </div>

                    </div>

                @else

                    {{-- Other user --}}
                    <div class="d-flex mb-3">

                        <div
                            class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center me-2"
                            style="width:35px;height:35px;">

                            {{ strtoupper(substr($message->user->name,0,1)) }}

                        </div>

                        <div>

                            <small class="fw-bold">

                                {{ $message->user->name }}

                            </small>

                            <div
                                class="bg-white border p-3"
                                style="max-width:450px;border-radius:18px 18px 18px 0;">

                                {{ $message->message }}

                                <div
                                    class="text-end text-muted mt-1"
                                    style="font-size:11px;">

                                    {{ $message->created_at->format('H:i') }}

                                </div>

                            </div>

                        </div>

                    </div>

                @endif

            @empty

                <p class="text-center text-muted">

                    No messages yet.

                </p>

            @endforelse

        </div>

        {{-- Send --}}
        <div class="card-footer">

            <form
                id="chatForm"
                action="{{ route('group.chat.send',$event) }}"
                method="POST">

                @csrf

                <div class="input-group">

                    <input
                        id="message"
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

</div>

<script>

function refreshChat(){

    let input=document.getElementById("message");

    let current=input.value;

    fetch(location.href)

    .then(res=>res.text())

    .then(html=>{

        let parser=new DOMParser();

        let doc=parser.parseFromString(html,"text/html");

        document.getElementById("chatBody").innerHTML=
        doc.getElementById("chatBody").innerHTML;

        input.value=current;

        let box=document.getElementById("chatBody");

        box.scrollTop=box.scrollHeight;

    });

}

setInterval(refreshChat,3000);

window.onload=function(){

    let box=document.getElementById("chatBody");

    box.scrollTop=box.scrollHeight;

};

document.getElementById("chatForm").addEventListener("submit",function(){

    setTimeout(function(){

        let box=document.getElementById("chatBody");

        box.scrollTop=box.scrollHeight;

    },100);

});

</script>
@endsection