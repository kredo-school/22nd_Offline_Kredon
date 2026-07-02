@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            {{-- メイン画像 --}}
            @if($event->image)
                <img src="{{ asset('storage/' . $event->image) }}" class="img-fluid rounded mb-4 w-100">
            @endif

            
            <h1 class="fw-bold">{{ $event->title }}</h1>
            <p class="text-muted">{{ $event->event_date }} | {{ $event->location }}</p>
            
            <div class="card p-4 mt-4">
                <h5 class="fw-bold">Description</h5>
                <p>{{ $event->description }}</p>
            </div>

            <a href="{{ route('chat.index', 1) }}"
            class="btn btn-primary">

                Message Owner

            </a>
        </div>
        
        <div class="col-lg-4">
            <div class="card p-4 shadow-sm">
                <h4 class="fw-bold">Event Details</h4>
                <a href="{{ route('event.index') }}" class="btn btn-outline-secondary mt-3">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection