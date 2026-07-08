@extends('layouts.app')

@section('title', 'Events')

@section('content')

    <div class="container-fluid px-4">
        {{-- EVENT BANNER --}}
        <div class="mb-4">
            <img src="{{ asset('images/event-banner.png') }}" alt="Kredon Events" class="w-100 rounded shadow-sm"
                style="display:block; width:100%; height:auto;">
        </div>

        {{-- NAVIGATION --}}
        <div class="d-flex flex-wrap mb-4 border-bottom">
            <a href="{{ route('event.index') }}" class="nav-link px-3"> All </a>
            <a href="{{ route('event.index', ['category' => 'Questions']) }}" class="nav-link px-3"> Questions </a>
            <a href="{{ route('event.index', ['category' => 'Events']) }}" class="nav-link px-3"> Events </a>
            <a href="{{ route('event.index', ['category' => 'Recruitment']) }}" class="nav-link px-3"> Recruitment </a>
            <a href="{{ route('event.index', ['category' => 'Share Info']) }}" class="nav-link px-3"> Share Info </a>
            <a href="{{ route('event.index', ['category' => 'Chat']) }}" class="nav-link px-3"> Chat </a>
            <a href="{{ route('event.index', ['category' => 'Others']) }}" class="nav-link px-3"> Others </a>
        </div>

        <div class="row">

            {{-- LEFT CONTENT --}}
            <div class="col-lg-9">

                {{-- CREATE EVENT --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body d-flex align-items-center">
                        <i class="fa-solid fa-calendar-days text-primary me-3 fa-lg"></i>
                        <div class="flex-grow-1">
                            <span class="text-muted">Create and share events with fellow Kredo students</span>
                        </div>
                        <a href="{{ route('event.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Create Event
                        </a>
                    </div>
                </div>

                {{-- EVENT CARDS --}}
                <div class="row g-3">
                    @forelse($events as $event)
                        <div style="flex: 0 0 20%; max-width: 20%; padding: 5px;">
                            <a href="{{ route('event.show', $event->id) }}" class="text-decoration-none text-dark">
                                <div class="card shadow-sm border-0 h-100" style="border-radius:8px; overflow:hidden;">
                                    <div class="position-relative">
                                        @if ($event->image1)
                                            <img src="{{ asset('storage/' . $event->image1) }}" class="card-img-top"
                                                style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover; display: block;">
                                        @endif

                                        @php
                                            $statusColor = match ($event->status_label) {
                                                'Now on' => 'success',
                                                'Upcoming' => 'info',
                                                'Before applications open' => 'secondary',
                                                default => 'light',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }} position-absolute"
                                            style="top:6px; right:6px; font-size:0.65rem; border: 2px solid black;">
                                            {{ $event->status_label }}
                                        </span>
                                    </div>

                                    <div class="card-body p-2">
                                        <h6 class="fw-bold mb-1"
                                            style="font-size:0.85rem; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                            {{ $event->title }}
                                        </h6>
                                        <p class="text-muted mb-1"
                                            style="font-size:0.75rem; height: 3em; overflow: hidden;">
                                            {{ \Illuminate\Support\Str::limit($event->description, 40) }}
                                        </p>
                                        @if ($event->start_date)
                                            <small class="text-primary">{{ $event->start_date->format('Y-m-d') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">No events available yet.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Upcoming Events</h5>
                        <hr>
                        @forelse($events->take(5) as $event)
                            <div class="mb-3">
                                <div class="fw-semibold small">{{ $event->title }}</div>
                                @if ($event->event_date)
                                    <div class="text-muted small">{{ $event->event_date }}</div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No upcoming events.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
