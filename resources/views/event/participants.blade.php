@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-body">

            <h2 class="mb-4">
                Participants
            </h2>
@forelse($participants as $user)

<div class="card mb-3">

    <div class="card-body d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center">

            <div
                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                style="width:50px;height:50px;">

                {{ strtoupper(substr($user->name,0,1)) }}

            </div>

            <div>

                <strong>{{ $user->name }}</strong>

            </div>

        </div>

        @if(auth()->id() != $user->id)

       <a href="{{ route('chat.private',$user->id) }}"
   class="btn btn-primary">

    Chat

</a>

        @endif

    </div>

</div>

@empty

<p>No participants.</p>

@endforelse

            <div class="mt-4">

                {{ $participants->links() }}

            </div>

        </div>

    </div>

</div>

@endsection