@extends('layouts.admin')

@section('title', 'Events Management')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">

        {{-- ── Header ── --}}
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">Events Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">イベントの作成・管理・分析を行います</p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                <div class="btn-group">
                    <button class="btn btn-dark btn-sm px-3 active">すべてのイベント</button>
                    <button class="btn btn-outline-secondary btn-sm px-3">期間限定</button>
                    <button class="btn btn-outline-secondary btn-sm px-3">レギュラー</button>
                </div>
                <button class="btn btn-outline-secondary btn-sm">
                    <i class="fa-regular fa-calendar"></i>
                </button>
            </div>
        </div>

        {{-- ── Metric Cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">総イベント数</p>
                        <h4 class="fw-bold mb-0">128</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">今月のイベント</p>
                        <h4 class="fw-bold mb-0">18 <span class="text-success fs-6">↑12%</span></h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">総参加者数</p>
                        <h4 class="fw-bold mb-0">5,842</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">今月の参加者</p>
                        <h4 class="fw-bold mb-0">1,027 <span class="text-success fs-6">↑18%</span></h4>
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
                            <h6 class="fw-bold mb-0">イベントカレンダー</h6>
                        </div>
                        {{-- Calendar Header --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <button class="btn btn-sm btn-light px-2 py-1">‹</button>
                            <span class="fw-semibold" style="font-size:0.9rem;">2025年5月</span>
                            <button class="btn btn-sm btn-light px-2 py-1">›</button>
                            <button class="btn btn-sm btn-outline-secondary px-2 py-1 ms-2"
                                style="font-size:0.75rem;">今日</button>
                        </div>
                        {{-- Calendar Grid --}}
                        <table class="w-100 text-center" style="font-size:0.78rem;">
                            <thead>
                                <tr>
                                    @foreach (['日', '月', '火', '水', '木', '金', '土'] as $d)
                                        <th class="pb-2 text-muted fw-normal">{{ $d }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $weeks = [
                                        [
                                            ['d' => 27, 'o' => true],
                                            ['d' => 28, 'o' => true],
                                            ['d' => 29, 'o' => true],
                                            ['d' => 30, 'o' => true],
                                            ['d' => 1, 'dot' => 'primary'],
                                            ['d' => 2, 'dot' => 'primary'],
                                            ['d' => 3],
                                        ],
                                        [
                                            ['d' => 4],
                                            ['d' => 5, 'dot' => 'primary'],
                                            ['d' => 6, 'dot' => 'primary'],
                                            ['d' => 7],
                                            ['d' => 8],
                                            ['d' => 9],
                                            ['d' => 10],
                                        ],
                                        [
                                            ['d' => 11],
                                            ['d' => 12],
                                            ['d' => 13],
                                            ['d' => 14, 'dot' => 'success'],
                                            ['d' => 15],
                                            ['d' => 16, 'dot' => 'primary'],
                                            ['d' => 17],
                                        ],
                                        [
                                            ['d' => 18],
                                            ['d' => 19, 'dot' => 'primary'],
                                            ['d' => 20],
                                            ['d' => 21],
                                            ['d' => 22],
                                            ['d' => 23, 'today' => true],
                                            ['d' => 24, 'dot' => 'primary'],
                                        ],
                                        [
                                            ['d' => 25],
                                            ['d' => 26],
                                            ['d' => 27],
                                            ['d' => 28],
                                            ['d' => 29],
                                            ['d' => 30, 'dot' => 'warning'],
                                            ['d' => 31],
                                        ],
                                    ];
                                @endphp
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
                        {{-- Legend --}}
                        <div class="d-flex gap-3 mt-3 justify-content-center" style="font-size:0.72rem;">
                            <span><span class="rounded-circle bg-primary d-inline-block me-1"
                                    style="width:8px;height:8px;"></span>期間限定イベント</span>
                            <span><span class="rounded-circle bg-success d-inline-block me-1"
                                    style="width:8px;height:8px;"></span>レギュラーイベント</span>
                            <span><span class="rounded-circle bg-warning d-inline-block me-1"
                                    style="width:8px;height:8px;"></span>その他</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 期間限定イベント --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">期間限定イベント</h6>
                            <a href="#" class="text-decoration-none"
                                style="font-size:0.78rem;color:darkcyan;">すべて見る</a>
                        </div>
                        @php
                            $limitedEvents = [
                                [
                                    'img' => null,
                                    'name' => 'CEBU FOOD FEST 2025',
                                    'date' => '2025-05-25 〜 2025-05-28',
                                    'place' => 'IT Park, Cebu City',
                                    'attendees' => 245,
                                    'status' => '開催中',
                                    'statusColor' => 'success',
                                ],
                                [
                                    'img' => null,
                                    'name' => 'SUMMER BEACH CLEANUP',
                                    'date' => '2025-06-01 〜 2025-06-01',
                                    'place' => 'Mactan Beach',
                                    'attendees' => 120,
                                    'status' => '予定',
                                    'statusColor' => 'info',
                                ],
                                [
                                    'img' => null,
                                    'name' => 'CEBU NIGHT MARKET',
                                    'date' => '2025-06-15 〜 2025-06-18',
                                    'place' => 'Sugbo Mercado',
                                    'attendees' => 310,
                                    'status' => '予定',
                                    'statusColor' => 'info',
                                ],
                                [
                                    'img' => null,
                                    'name' => 'KREDON ANNIVERSARY',
                                    'date' => '2025-07-01 〜 2025-07-02',
                                    'place' => 'Ayala Center Cebu',
                                    'attendees' => 80,
                                    'status' => '申込受付前',
                                    'statusColor' => 'secondary',
                                ],
                            ];
                        @endphp
                        <div class="d-flex flex-column gap-3">
                            @foreach ($limitedEvents as $ev)
                                <div class="d-flex gap-2 align-items-start">
                                    <div class="rounded flex-shrink-0 bg-secondary" style="width:60px;height:48px;"></div>
                                    <div class="flex-grow-1" style="font-size:0.78rem;">
                                        <div class="fw-semibold">{{ $ev['name'] }}</div>
                                        <div class="text-muted"><i
                                                class="fa-regular fa-calendar fa-xs me-1"></i>{{ $ev['date'] }}</div>
                                        <div class="text-muted"><i
                                                class="fa-solid fa-location-dot fa-xs me-1"></i>{{ $ev['place'] }}</div>
                                        <div class="text-muted">参加者：{{ $ev['attendees'] }}人</div>
                                    </div>
                                    <span class="badge bg-{{ $ev['statusColor'] }} flex-shrink-0"
                                        style="font-size:0.68rem;">{{ $ev['status'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- レギュラーイベント --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">レギュラーイベント</h6>
                            <a href="#" class="text-decoration-none"
                                style="font-size:0.78rem;color:darkcyan;">すべて見る</a>
                        </div>
                        @php
                            $regularEvents = [
                                [
                                    'name' => 'WEEKLY RUN CLUB',
                                    'schedule' => '毎週 土曜日 06:00',
                                    'place' => 'IT Park',
                                    'attendees' => 156,
                                ],
                                [
                                    'name' => 'LANGUAGE EXCHANGE',
                                    'schedule' => '毎週 金曜日 19:00',
                                    'place' => 'KREDON Community Hub',
                                    'attendees' => 89,
                                ],
                                [
                                    'name' => 'YOGA CLASS',
                                    'schedule' => '毎週 日曜日 07:00',
                                    'place' => 'Ayala Center',
                                    'attendees' => 67,
                                ],
                                [
                                    'name' => 'COFFEE MEETUP',
                                    'schedule' => '毎週 水曜日 18:30',
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
                                        <div class="text-muted">参加者：{{ $ev['attendees'] }}人</div>
                                    </div>
                                    <span class="badge bg-success flex-shrink-0" style="font-size:0.68rem;">定期開催中</span>
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
                            <h6 class="fw-bold mb-0">参加者リスト（直近のイベント）</h6>
                            <a href="#" class="text-decoration-none"
                                style="font-size:0.78rem;color:darkcyan;">すべて見る</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th>参加者名</th>
                                        <th>イベント名</th>
                                        <th>参加日</th>
                                        <th>ステータス</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $attendees = [
                                            [
                                                'name' => 'John D.',
                                                'event' => 'CEBU FOOD FEST 2025',
                                                'date' => '2025-05-23 18:30',
                                                'status' => '参加済み',
                                                'color' => 'success',
                                            ],
                                            [
                                                'name' => 'Maria S.',
                                                'event' => 'SUMMER BEACH CLEANUP',
                                                'date' => '2025-05-23 17:45',
                                                'status' => '参加確定',
                                                'color' => 'primary',
                                            ],
                                            [
                                                'name' => 'David L.',
                                                'event' => 'CEBU NIGHT MARKET',
                                                'date' => '2025-05-23 16:20',
                                                'status' => '参加済み',
                                                'color' => 'success',
                                            ],
                                            [
                                                'name' => 'Sarah K.',
                                                'event' => 'WEEKLY RUN CLUB',
                                                'date' => '2025-05-23 06:00',
                                                'status' => '参加済み',
                                                'color' => 'success',
                                            ],
                                            [
                                                'name' => 'Michael T.',
                                                'event' => 'LANGUAGE EXCHANGE',
                                                'date' => '2025-05-22 19:00',
                                                'status' => '参加済み',
                                                'color' => 'success',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($attendees as $a)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        style="display:inline-flex;align-items:center;justify-content:center;
                                                         width:30px;height:30px;border-radius:50%;background:#dee2e6;
                                                         font-size:0.72rem;font-weight:bold;color:#495057;">
                                                        {{ strtoupper(substr($a['name'], 0, 1)) }}
                                                    </span>
                                                    {{ $a['name'] }}
                                                </div>
                                            </td>
                                            <td>{{ $a['event'] }}</td>
                                            <td class="text-nowrap">{{ $a['date'] }}</td>
                                            <td><span class="badge bg-{{ $a['color'] }}"
                                                    style="font-size:0.72rem;">{{ $a['status'] }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- イベント統計 --}}
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">イベント統計</h6>
                            <select class="form-select form-select-sm" style="width:auto;font-size:0.78rem;">
                                <option>過去30日間</option>
                                <option>過去7日間</option>
                                <option>過去90日間</option>
                            </select>
                        </div>
                        {{-- Stats --}}
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">総参加者数</p>
                                <div class="fw-bold">1,823 <span class="text-success"
                                        style="font-size:0.75rem;">↑18.2%</span></div>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">新規参加者</p>
                                <div class="fw-bold">342 <span class="text-success"
                                        style="font-size:0.75rem;">↑12.5%</span></div>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">イベント開催数</p>
                                <div class="fw-bold">24 <span class="text-success"
                                        style="font-size:0.75rem;">↑20.0%</span></div>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-0" style="font-size:0.75rem;">キャンセル数</p>
                                <div class="fw-bold">87 <span class="text-danger" style="font-size:0.75rem;">↓5.3%</span>
                                </div>
                            </div>
                        </div>
                        {{-- Chart placeholder --}}
                        <div>
                            <p class="text-muted mb-1" style="font-size:0.75rem;">参加者推移</p>
                            <canvas id="attendeesChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
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
