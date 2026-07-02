@extends('layouts.app')

@section('title','Chat')

@section('content')

<div class="container">

    <div class="card border-0 shadow-sm">

        {{-- Header --}}
        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                Chat Room
            </h5>

        </div>

        {{-- Messages --}}
        <div class="card-body"
             style="
                height:500px;
                overflow-y:auto;
                background:#f5f5f5;
             ">

            @foreach($chat->messages as $message)

                @if($message->user_id == auth()->id())

                    {{-- My Message --}}
                    <div class="d-flex justify-content-end mb-3">

                        <div
                            class="p-2 text-white"
                            style="
                                background:#0d6efd;
                                border-radius:15px;
                                max-width:70%;
                            ">

                            {{ $message->message }}

                            <div
                                class="small text-end mt-1"
                                style="font-size:10px;">

                                {{ $message->created_at->format('H:i') }}

                            </div>

                        </div>

                    </div>

                @else

                    {{-- Other User --}}
                    <div class="d-flex justify-content-start mb-3">

                        <div
                            class="p-2 bg-white border"
                            style="
                                border-radius:15px;
                                max-width:70%;
                            ">

                            {{ $message->message }}

                            <div
                                class="small text-muted mt-1"
                                style="font-size:10px;">

                                {{ $message->created_at->format('H:i') }}

                            </div>

                        </div>

                    </div>

                @endif

            @endforeach

        </div>

        {{-- Send Form --}}
        <div class="card-footer bg-white">

            <form
                action="{{ route('chat.send',$chat->id) }}"
                method="POST">

                @csrf

                <div class="input-group">

                    <input
                        type="text"
                        name="message"
                        class="form-control"
                        placeholder="Type a message..."
                        required>

                    <button
                        class="btn btn-primary">

                        Send

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- Auto Scroll --}}
<script>
window.onload = function() {
    let chatBody = document.querySelector('.card-body');
    chatBody.scrollTop = chatBody.scrollHeight;
}
</script>

@endsection