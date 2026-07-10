@extends('layouts.admin')

@section('title', 'Events Management')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">

        {{-- ── Header ── --}}
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">Events Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">We create, manage and analyze events</p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                {{-- <div class="btn-group">
                    <button class="btn btn-dark btn-sm px-3 active">All Events</button>
                    <button class="btn btn-outline-secondary btn-sm px-3">Limited-time event</button>
                    <button class="btn btn-outline-secondary btn-sm px-3">Regular events</button>
                </div> --}}
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fa-regular fa-calendar"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal"
                    data-bs-target="#createEventModal">
                    <i class="fa-solid fa-plus me-1"></i>Create Event
                </button>
            </div>
        </div>

        {{-- ── Metric Cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">All events</p>
                        <h4 class="fw-bold mb-0">{{ $allEventsCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Now on</p>
                        <h4 class="fw-bold mb-0">{{ $nowOnCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">Upcoming events</p>
                        <h4 class="fw-bold mb-0">{{ $upcomingEventsCount }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">This Month’s Participants</p>
                        <h4 class="fw-bold mb-0">
                            {{ number_format($thisMonthParticipants) }}
                            <span class="{{ $participantsGrowth >= 0 ? 'text-success' : 'text-danger' }} fs-6">
                                {{ $participantsGrowth >= 0 ? '↑' : '↓' }}{{ abs($participantsGrowth) }}%
                            </span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Middle Row ── --}}
        <div class="row g-3 mb-4">

            {{-- カレンダー --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Event Calender</h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <a href="{{ route('admin.events.index', ['month' => $month - 1 < 1 ? 12 : $month - 1, 'year' => $month - 1 < 1 ? $year - 1 : $year]) }}"
                                class="btn btn-sm btn-light px-2 py-1">‹</a>
                            <span class="fw-semibold" style="font-size:0.9rem;">{{ $calendarLabel }}</span>
                            <a href="{{ route('admin.events.index', ['month' => $month + 1 > 12 ? 1 : $month + 1, 'year' => $month + 1 > 12 ? $year + 1 : $year]) }}"
                                class="btn btn-sm btn-light px-2 py-1">›</a>
                            <a href="{{ route('admin.events.index') }}"
                                class="btn btn-sm btn-outline-secondary px-2 py-1 ms-2" style="font-size:0.75rem;">Today</a>
                        </div>
                        <table class="w-100 text-center" style="font-size:0.78rem;">
                            <thead>
                                <tr>
                                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $d)
                                        <th class="pb-2 text-muted fw-normal">{{ $d }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($weeks as $week)
                                    <tr>
                                        @foreach ($week as $day)
                                            <td class="py-1" style="width:14.28%;">
                                                <div class="d-inline-flex flex-column align-items-center">
                                                    <span
                                                        class="{{ isset($day['today']) ? 'bg-dark text-white rounded-circle d-inline-flex align-items-center justify-content-center' : (isset($day['o']) ? 'text-muted' : '') }}"
                                                        style="{{ isset($day['today']) ? 'width:24px;height:24px;font-size:0.78rem;' : '' }}">
                                                        {{ $day['d'] }}
                                                    </span>
                                                    @if (isset($day['dot']))
                                                        <span class="rounded-circle bg-{{ $day['dot'] }}"
                                                            style="width:5px;height:5px;margin-top:2px;"></span>
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex gap-3 mt-3 justify-content-center" style="font-size:0.72rem;">
                            <span><span class="rounded-circle bg-primary d-inline-block me-1"
                                    style="width:8px;height:8px;"></span>Limited-time</span>
                            <span><span class="rounded-circle bg-success d-inline-block me-1"
                                    style="width:8px;height:8px;"></span>Regular</span>
                            <span><span class="rounded-circle bg-warning d-inline-block me-1"
                                    style="width:8px;height:8px;"></span>Others</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 期間限定イベント --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Limited-time event</h6>
                            <a href="#" class="text-decoration-none" style="font-size:0.78rem;color:darkcyan;">View
                                all</a>
                        </div>
                        <div class="d-flex flex-column gap-3">
                            @forelse ($limitedEvents as $ev)
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="rounded flex-shrink-0" style="width:60px;height:48px;">
                                        @if ($ev->image1)
                                            <img src="{{ Storage::url($ev->image1) }}" class="rounded w-100 h-100"
                                                style="object-fit:cover;">
                                        @else
                                            <div class="bg-secondary w-100 h-100 rounded"></div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1" style="font-size:0.78rem;">
                                        <div class="fw-semibold">{{ $ev->title }}</div>
                                        <div class="text-muted">
                                            <i class="fa-regular fa-calendar fa-xs me-1"></i>
                                            {{ $ev->start_date->format('Y-m-d') }} 〜
                                            {{ $ev->end_date->format('Y-m-d') }}
                                        </div>
                                        <div class="text-muted"><i
                                                class="fa-solid fa-location-dot fa-xs me-1"></i>{{ $ev->location }}
                                        </div>
                                        <div class="text-muted">Participants：{{ $ev->participants_count }} per</div>
                                    </div>
                                    @php
                                        $statusColor = match ($ev->status_label) {
                                            'Now on' => 'success',
                                            'Upcoming' => 'info',
                                            'Before applications open' => 'primary',
                                            'Ended' => 'secondary',
                                            default => 'light',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} flex-shrink-0" style="font-size:0.68rem;">
                                        {{ $ev->status_label }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-muted mb-0" style="font-size:0.82rem;">No Event yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- レギュラーイベント（今回スコープ外・ダミーのまま） --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Regular event</h6>
                            <a href="#" class="text-decoration-none" style="font-size:0.78rem;color:darkcyan;">View
                                all</a>
                        </div>
                        @php
                            $regularEvents = [
                                [
                                    'name' => 'WEEKLY RUN CLUB',
                                    'schedule' => 'every Sat 06:00',
                                    'place' => 'IT Park',
                                    'attendees' => 156,
                                ],
                                [
                                    'name' => 'LANGUAGE EXCHANGE',
                                    'schedule' => 'every Sun 19:00',
                                    'place' => 'KREDON Community Hub',
                                    'attendees' => 89,
                                ],
                                [
                                    'name' => 'YOGA CLASS',
                                    'schedule' => 'every Mon 07:00',
                                    'place' => 'Ayala Center',
                                    'attendees' => 67,
                                ],
                                [
                                    'name' => 'COFFEE MEETUP',
                                    'schedule' => 'every Sun 18:30',
                                    'place' => "Bo's Coffee, IT Park",
                                    'attendees' => 134,
                                ],
                            ];
                        @endphp
                        <div class="d-flex flex-column gap-3">
                            @foreach ($regularEvents as $ev)
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="rounded flex-shrink-0 bg-secondary" style="width:60px;height:48px;"></div>
                                    <div class="flex-grow-1" style="font-size:0.78rem;">
                                        <div class="fw-semibold">{{ $ev['name'] }}</div>
                                        <div class="text-muted"><i
                                                class="fa-regular fa-clock fa-xs me-1"></i>{{ $ev['schedule'] }}</div>
                                        <div class="text-muted"><i
                                                class="fa-solid fa-location-dot fa-xs me-1"></i>{{ $ev['place'] }}</div>
                                        <div class="text-muted">Participants：{{ $ev['attendees'] }}人</div>
                                    </div>
                                    <span class="badge bg-success flex-shrink-0" style="font-size:0.68rem;">Held
                                        regularly</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Bottom Row ── --}}
        <div class="row g-3">

            {{-- 参加者リスト --}}
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Participants list</h6>
                            <a href="#" class="text-decoration-none" style="font-size:0.78rem;color:darkcyan;">View
                                all</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Owner</th>
                                        <th>Event title</th>
                                        <th>Day</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentParticipants as $p)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        style="display:inline-flex;align-items:center;justify-content:center;
                                                         width:30px;height:30px;border-radius:50%;background:#dee2e6;
                                                         font-size:0.72rem;font-weight:bold;color:#495057;">
                                                        {{ strtoupper(substr($p->user->name ?? '?', 0, 1)) }}
                                                    </span>
                                                    {{ $p->user->name ?? 'Unknown' }}
                                                </div>
                                            </td>
                                            <td>{{ $p->event->title ?? 'Deleted event' }}</td>
                                            <td class="text-nowrap">{{ $p->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                                            <td><span class="badge bg-success" style="font-size:0.72rem;">Already
                                                    Participated</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-muted text-center py-3">No participants yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- イベント統計（今回スコープ外・ダミーのまま） --}}
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Event Statics</h6>
                            <select class="form-select form-select-sm" style="width:auto;font-size:0.78rem;">
                                <option>Over the past 30 days</option>
                                <option>Over the past 7 days</option>
                                <option>Over the past 90 days</option>
                            </select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Total number of participants</p>
                                <div class="fw-bold">1,823 <span class="text-success"
                                        style="font-size:0.75rem;">↑18.2%</span></div>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Number of new participants</p>
                                <div class="fw-bold">342 <span class="text-success"
                                        style="font-size:0.75rem;">↑12.5%</span></div>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Number of events held</p>
                                <div class="fw-bold">24 <span class="text-success"
                                        style="font-size:0.75rem;">↑20.0%</span></div>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">Number of cancellations</p>
                                <div class="fw-bold">87 <span class="text-danger" style="font-size:0.75rem;">↓5.3%</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="text-muted mb-1" style="font-size:0.75rem;">Trends in Participant Numbers</p>
                            <canvas id="attendeesChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Create Eventモーダル（別blade） --}}
    @include('admin.events.create-modal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('attendeesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['4/24', '4/28', '5/2', '5/6', '5/10', '5/14', '5/18', '5/22'],
                datasets: [{
                    data: [600, 750, 500, 680, 720, 810, 870, 840],
                    borderColor: 'darkcyan',
                    backgroundColor: 'rgba(0,139,139,0.08)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: 'darkcyan',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 10
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
