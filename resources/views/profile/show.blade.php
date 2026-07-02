@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="container">

    <div class="card shadow-sm border-0">

        <div class="card-body text-center">

            {{-- Avatar --}}
            <div class="mb-3">

                @if($user->avatar)

                    <img
                        src="{{ asset('storage/' . $user->avatar) }}"
                        style="
                            width:120px;
                            height:120px;
                            border-radius:50%;
                            object-fit:cover;
                        ">

                @else

                    <div style="
                        width:120px;
                        height:120px;
                        border-radius:50%;
                        background:#0d6efd;
                        color:white;
                        font-size:40px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        margin:auto;
                    ">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>

                @endif

            </div>

            <h3 class="fw-bold">

                {{ $user->name }}

            </h3>

            <p class="text-muted">

                {{ $user->email }}

            </p>

            <hr>

            <a
                href="{{ route('chat.index',$user->id) }}"
                class="btn btn-primary">

                Message

            </a>

        </div>

    </div>

</div>

@endsection