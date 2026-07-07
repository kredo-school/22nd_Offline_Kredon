@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">

        Participants

    </h2>

    <div class="card">

        <div class="list-group list-group-flush">

            @foreach($members as $member)

                <div
                    class="list-group-item d-flex align-items-center">

                    <div
                        class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3"
                        style="width:45px;height:45px;">

                        {{ strtoupper(substr($member->name,0,1)) }}

                    </div>

                    <div>

                        <strong>

                            {{ $member->name }}

                        </strong>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

    <a
        href="{{ route('group.chat',$event) }}"
        class="btn btn-secondary mt-3">

        ← Back

    </a>

</div>

@endsection