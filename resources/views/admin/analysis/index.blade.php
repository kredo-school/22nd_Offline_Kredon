@extends('layouts.admin')

@section('title', 'Analysis')

@section('content')
    <div class="p-4">

        {{-- ── Header ── --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <h4 class="fw-bold mb-0">Analysis Page</h4>
            <div class="d-flex align-items-center gap-2 ms-2">
                <span class="text-muted" style="font-size:0.85rem;">Compare Period</span>
                <select class="form-select form-select-sm" style="width:auto;">
                    <option>Last 30 Days</option>
                    <option>Last 7 Days</option>
                    <option>Last 90 Days</option>
                </select>
                <span class="text-muted" style="font-size:0.85rem;">- Compare</span>
                <button class="btn btn-outline-secondary btn-sm px-2 py-1">
                    <i class="fa-regular fa-calendar fa-xs"></i>
                </button>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
         Row 1: Users Deep-Dive | Spots/Reviews Performance
    ══════════════════════════════════════════════════════ --}}
        <div class="row g-3 mb-3">

            {{-- ── Left: Users Deep-Dive ── --}}
            <div class="col-12 col-xxl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-3">Users Deep-Dive <span class="text-muted fw-normal"
                                style="font-size:0.78rem;">(Migrated from Users)</span></h6>
                        <div class="row g-3">

                            {{-- User Growth Trend --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <span style="font-size:0.78rem; font-weight:600;">User Growth & Churn Trend</span>
                                        <div class="text-end">
                                            <div style="font-size:0.7rem; color:#6c757d;">Total Users</div>
                                            <div class="fw-bold" style="font-size:1.1rem; line-height:1.2;">
                                                {{ number_format(end($growth['totalSeries']) ?: 0) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div style="font-size:0.68rem; color:#6c757d;" class="mb-1">
                                        <span class="me-2"><span style="color:#4a90d9;">●</span> Cumulative
                                            Registrations</span>
                                        <span><span style="color:#e8516a;">●</span> Cumulative Churn</span>
                                    </div>
                                    <div style="position:relative; height:160px;">
                                        <canvas id="userGrowthChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- Dormancy Funnel --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">Dormancy Funnel (Days Since
                                        Last Login)</div>
                                    <div style="position:relative; height:120px;"><canvas id="dormancyChart"></canvas></div>
                                </div>
                            </div>

                            {{-- User Activity Funnel --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">User Activity Funnel</div>
                                    <div id="funnelChart" style="font-size:0.72rem;">
                                        @php
                                            $funnel = [
                                                ['label' => 'Registered Users', 'pct' => 100, 'color' => '#4a90d9'],
                                                ['label' => 'Logged in Users', 'pct' => 78, 'color' => '#5cb85c'],
                                                ['label' => 'Active Users', 'pct' => 52, 'color' => '#f0ad4e'],
                                                ['label' => 'Posted Spots', 'pct' => 24, 'color' => '#e8516a'],
                                                ['label' => 'Joined Events', 'pct' => 11, 'color' => '#c0392b'],
                                            ];
                                            $maxPct = 100;
                                        @endphp
                                        @foreach ($funnel as $f)
                                            @php $barW = round(($f['pct'] / $maxPct) * 100); @endphp
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <div
                                                    style="background:{{ $f['color'] }};width:{{ $barW }}%;min-width:28px;
                                                    text-align:center;color:#fff;border-radius:2px;padding:1px 4px;
                                                    font-size:0.68rem;font-weight:600;">
                                                    {{ $f['pct'] }}%
                                                </div>
                                                <span class="text-muted"
                                                    style="font-size:0.7rem;white-space:nowrap;">{{ $f['label'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Notification Open Rate --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">Notification Open Rate</div>
                                    @php
                                        $notifOpenRate = [
                                            'rate' => 64,
                                            'sent' => 1240,
                                            'opened' => 794,
                                        ];
                                    @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="position:relative;width:100px;height:100px;flex-shrink:0;">
                                            <canvas id="notifOpenRateChart"></canvas>
                                            <div
                                                style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                                                <div class="fw-bold" style="font-size:1.1rem;line-height:1;">
                                                    {{ $notifOpenRate['rate'] }}%</div>
                                                <div class="text-muted" style="font-size:0.6rem;">Open Rate</div>
                                            </div>
                                        </div>
                                        <div style="font-size:0.7rem;">
                                            <div class="mb-1"><span style="color:#4a90d9;">■</span> Opened
                                                [{{ number_format($notifOpenRate['opened']) }}]</div>
                                            <div><span style="color:#e0e0e0;">■</span> Unopened
                                                [{{ number_format($notifOpenRate['sent'] - $notifOpenRate['opened']) }}]
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size:0.65rem;">Based on
                                        {{ number_format($notifOpenRate['sent']) }} notifications sent</div>
                                </div>
                            </div>

                            {{-- Role Comparison --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100" style="overflow-x: auto;">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">Role Comparison</div>
                                    @php
                                        $roleActivityComparison = [
                                            'Admin' => [
                                                'top_active' => 4,
                                                'avg_posts' => 12.3,
                                                'avg_reviews' => 8.1,
                                                'avg_events' => 3.4,
                                            ],
                                            'Moderator' => [
                                                'top_active' => 9,
                                                'avg_posts' => 9.7,
                                                'avg_reviews' => 6.5,
                                                'avg_events' => 2.8,
                                            ],
                                            'Regular User' => [
                                                'top_active' => 156,
                                                'avg_posts' => 3.2,
                                                'avg_reviews' => 2.4,
                                                'avg_events' => 1.1,
                                            ],
                                            'Premium User' => [
                                                'top_active' => 42,
                                                'avg_posts' => 5.6,
                                                'avg_reviews' => 4.9,
                                                'avg_events' => 2.2,
                                            ],
                                        ];
                                    @endphp
                                    <table class="table table-sm mb-0" style="font-size:0.7rem;">
                                        <thead>
                                            <tr class="text-muted">
                                                <th class="py-0">Role</th>
                                                <th class="py-0 text-center">Top Active Users</th>
                                                <th class="py-0 text-center">Avg. Posts</th>
                                                <th class="py-0 text-center">Avg. Reviews</th>
                                                <th class="py-0 text-center">Avg. Event Participation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roleActivityComparison as $label => $stats)
                                                <tr>
                                                    <td class="py-1">{{ $label }}</td>
                                                    <td class="py-1 text-center">{{ $stats['top_active'] }}</td>
                                                    <td class="py-1 text-center">{{ $stats['avg_posts'] }}</td>
                                                    <td class="py-1 text-center">{{ $stats['avg_reviews'] }}</td>
                                                    <td class="py-1 text-center">{{ $stats['avg_events'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Login Count Distribution --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">Login Count Distribution</div>
                                    <div style="position:relative; height:140px;"><canvas id="loginDistChart"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Right: Spots / Reviews Performance ── --}}
            <div class="col-12 col-xxl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-3">Spots / Reviews Performance <span class="text-muted fw-normal"
                                style="font-size:0.78rem;">(Migrated from Spots/Reviews)</span></h6>
                        <div class="row g-3">

                            {{-- Spot Evaluation Ranking --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100" style="overflow-x: auto;">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">Spot Evaluation Ranking</div>
                                    <table class="table table-sm mb-0" style="font-size:0.7rem;">
                                        <thead>
                                            <tr class="text-muted">
                                                <th class="py-0 ps-0" style="width:16px;">Rank</th>
                                                <th class="py-0">Spot</th>
                                                <th class="py-0 text-center">Avg.</th>
                                                <th class="py-0 text-center">Reviews</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $spots = [
                                                    [
                                                        'name' => 'Tops Mountain',
                                                        'sub' => '373 Reviews',
                                                        'stars' => 5,
                                                        'reviews' => 123,
                                                        'rank' => 1,
                                                    ],
                                                    [
                                                        'name' => 'Kredon Cebu Cafe',
                                                        'sub' => '357 Reviews',
                                                        'stars' => 5,
                                                        'reviews' => 133,
                                                        'rank' => 2,
                                                    ],
                                                    [
                                                        'name' => 'Kredon Cebu Cafe',
                                                        'sub' => '273 Reviews',
                                                        'stars' => 4,
                                                        'reviews' => 103,
                                                        'rank' => 3,
                                                    ],
                                                    [
                                                        'name' => 'Kredon Cebu Cafe',
                                                        'sub' => '137 Reviews',
                                                        'stars' => 4,
                                                        'reviews' => 97,
                                                        'rank' => 4,
                                                    ],
                                                    [
                                                        'name' => 'Kredon Cebu Cafe',
                                                        'sub' => '121 Reviews',
                                                        'stars' => 4,
                                                        'reviews' => 43,
                                                        'rank' => 5,
                                                    ],
                                                    [
                                                        'name' => 'Tops Mountain',
                                                        'sub' => '357 Reviews',
                                                        'stars' => 5,
                                                        'reviews' => 35,
                                                        'rank' => 6,
                                                    ],
                                                    [
                                                        'name' => 'Kredon Cebu Cafe',
                                                        'sub' => '121 Reviews',
                                                        'stars' => 4,
                                                        'reviews' => 13,
                                                        'rank' => 7,
                                                    ],
                                                    [
                                                        'name' => 'Tops Mountain',
                                                        'sub' => '115 Reviews',
                                                        'stars' => 3,
                                                        'reviews' => 13,
                                                        'rank' => 8,
                                                    ],
                                                    [
                                                        'name' => 'Kredon Cebu Cafe',
                                                        'sub' => '227 Reviews',
                                                        'stars' => 4,
                                                        'reviews' => 10,
                                                        'rank' => 9,
                                                    ],
                                                    [
                                                        'name' => 'Kredon Cebu Cafe',
                                                        'sub' => '127 Reviews',
                                                        'stars' => 3,
                                                        'reviews' => 15,
                                                        'rank' => 10,
                                                    ],
                                                ];
                                            @endphp
                                            @foreach ($spots as $s)
                                                <tr>
                                                    <td class="ps-0 py-1">{{ $s['rank'] }}</td>
                                                    <td class="py-1">
                                                        <div class="fw-medium" style="font-size:0.68rem;line-height:1.2;">
                                                            {{ $s['name'] }}</div>
                                                        <div class="text-muted" style="font-size:0.62rem;">
                                                            {{ $s['sub'] }}</div>
                                                    </td>
                                                    <td class="py-1 text-center text-warning"
                                                        style="font-size:0.65rem;letter-spacing:-1px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <span
                                                                style="{{ $i > $s['stars'] ? 'opacity:0.3' : '' }}">★</span>
                                                        @endfor
                                                    </td>
                                                    <td class="py-1 text-center">{{ $s['reviews'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Right sub-column: Traffic Top 10 + Evaluation Distribution --}}
                            <div class="col-12 col-sm-6 d-flex flex-column gap-3">

                                {{-- Traffic Top 10 --}}
                                <div class="border rounded p-2 flex-fill">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">Traffic Top 10 (Checks &
                                        Views)</div>
                                    <div style="position:relative; height:150px;"><canvas id="trafficChart"></canvas>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3 mt-1" style="font-size:0.68rem;">
                                        <span><span style="color:#4a90d9;">■</span> Checks & Views</span>
                                        <span><span style="color:#f0ad4e;">■</span> Bookmark Rate</span>
                                    </div>
                                </div>

                                {{-- Evaluation Distribution Graph --}}
                                <div class="border rounded p-2 flex-fill">
                                    <div class="fw-semibold mb-2" style="font-size:0.78rem;">Evaluation Distribution Graph
                                    </div>
                                    <div style="position:relative; height:150px;"><canvas id="evalDistChart"></canvas>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--    Row 2: Overall Insights | Engagement Metrics   --}}
        <div class="row g-3">

            {{-- ── Left: Overall Insights ── --}}
            <div class="col-12 col-xxl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-3">Overall Insights <span class="text-muted fw-normal"
                                style="font-size:0.78rem;">(Across Categories)</span></h6>
                        <div class="row g-3">

                            {{-- Category Post Trend --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-1" style="font-size:0.78rem;">Category Post Trend (Spots &
                                        Events)</div>
                                    <div class="d-flex flex-wrap gap-2 mb-1" style="font-size:0.68rem;">
                                        <span><span style="color:#4a90d9;">●</span> Cafe</span>
                                        <span><span style="color:#e8516a;">●</span> Cafe</span>
                                        <span><span style="color:#f0ad4e;">●</span> Restaurant</span>
                                        <span><span style="color:#5cb85c;">●</span> Events</span>
                                    </div>
                                    <div style="position:relative; height:140px;"><canvas
                                            id="categoryTrendChart"></canvas></div>
                                </div>
                            </div>

                            {{-- Reporting Breakdown --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-1" style="font-size:0.78rem;">Reporting Breakdown (By
                                        Category)</div>
                                    <div class="d-flex align-items-center gap-2 mt-2">
                                        <div style="position:relative;width:120px;height:120px;flex-shrink:0;">
                                            <canvas id="reportingChart"></canvas>
                                            <div
                                                style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                                                <div class="fw-bold" style="font-size:1rem;line-height:1;">23</div>
                                                <div class="text-muted" style="font-size:0.62rem;">Reports</div>
                                            </div>
                                        </div>
                                        <div style="font-size:0.7rem;">
                                            <div class="mb-1"><span style="color:#e8516a;">■</span> Inappropriate
                                                Content [15]</div>
                                            <div class="mb-1"><span style="color:#4a90d9;">■</span> Duplicate [8]</div>
                                            <div class="mb-1"><span style="color:#5cb85c;">■</span> Reports [3]</div>
                                            <div><span style="color:#f0ad4e;">■</span> Outdated [3]</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Right: Engagement Metrics ── --}}
            <div class="col-12 col-xxl-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-3">Engagement Metrics</h6>
                        <div class="row g-3">

                            {{-- Engagement Rate Trend --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-1" style="font-size:0.78rem;">Engagement Rate Trend</div>
                                    <div class="text-muted mb-1" style="font-size:0.65rem;">Engagement Rate (%)</div>
                                    <div style="position:relative; height:120px;"><canvas id="engagementChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            {{-- Activity Type Breakdown --}}
                            <div class="col-12 col-sm-6">
                                <div class="border rounded p-2 h-100">
                                    <div class="fw-semibold mb-1" style="font-size:0.78rem;">Activity Type Breakdown</div>
                                    <div style="position:relative; height:120px;"><canvas id="activityChart"></canvas>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            Chart.defaults.font.family = 'inherit';
            Chart.defaults.font.size = 10;
            Chart.defaults.color = '#6c757d';

            // 💡 修正ポイント3: 全てのチャートで縦横比を正しく維持しつつレスポンシブ対応させるオプションをデフォルト適用します
            Chart.defaults.responsive = true;
            Chart.defaults.maintainAspectRatio = false;

            const years = ['2024', '2024', '2025', '2026'];

            // ── User Growth & Churn Trend ──
            new Chart(document.getElementById('userGrowthChart'), {
                type: 'line',
                data: {
                    labels: @json($growth['labels']),
                    datasets: [{
                            label: 'Cumulative Registrations',
                            data: @json($growth['totalSeries']),
                            borderColor: '#4a90d9',
                            backgroundColor: 'rgba(74,144,217,0.08)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 2,
                        },
                        {
                            label: 'Cumulative Churn',
                            data: @json($growth['churnSeries']),
                            borderColor: '#e8516a',
                            backgroundColor: 'transparent',
                            tension: 0.4,
                            pointRadius: 2,
                        },
                    ],
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
                                    size: 9
                                }
                            }
                        },
                        y: {
                            ticks: {
                                font: {
                                    size: 9
                                },
                                maxTicksLimit: 5
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                    },
                },
            });

            // ── Dormancy Funnel ──
            new Chart(document.getElementById('dormancyChart'), {
                type: 'bar',
                data: {
                    labels: ['Active (0-7d)', 'Cooling (8-30d)', 'Dormant (31-90d)', 'Long Dormant (90d+)'],
                    datasets: [{
                        data: [
                            {{ $dormancy['active'] }},
                            {{ $dormancy['cooling'] }},
                            {{ $dormancy['dormant'] }},
                            {{ $dormancy['long_dormant'] }},
                        ],
                        backgroundColor: ['#5cb85c', '#f0ad4e', '#e8516a', '#a0a0a0'],
                        barPercentage: 0.6,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 8
                                }
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 8
                                }
                            }
                        },
                    },
                },
            });

            // ── Notification Open Rate (doughnut) ──
            new Chart(document.getElementById('notifOpenRateChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Opened', 'Unopened'],
                    datasets: [{
                        data: [{{ $notifOpenRate['opened'] }},
                            {{ $notifOpenRate['sent'] - $notifOpenRate['opened'] }}
                        ],
                        backgroundColor: ['#4a90d9', '#e0e0e0'],
                        borderWidth: 1,
                    }],
                },
                options: {
                    cutout: '65%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                },
            });

            // ── Login Count Distribution ──
            new Chart(document.getElementById('loginDistChart'), {
                type: 'bar',
                data: {
                    labels: @json(array_keys($loginDistribution)),
                    datasets: [{
                        data: @json(array_values($loginDistribution)),
                        backgroundColor: '#4a90d9',
                        barPercentage: 0.6,
                    }],
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
                                    size: 8
                                }
                            }
                        },
                        y: {
                            ticks: {
                                font: {
                                    size: 8
                                },
                                maxTicksLimit: 5
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                    },
                },
            });

            // ── Traffic Top 10 (horizontal bar) ──
            new Chart(document.getElementById('trafficChart'), {
                type: 'bar',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                    datasets: [{
                            label: 'Checks & Views',
                            data: [380, 310, 270, 240, 200, 170, 140, 110, 80, 60],
                            backgroundColor: '#4a90d9',
                            barPercentage: 0.5
                        },
                        {
                            label: 'Bookmark Rate',
                            data: [120, 100, 85, 75, 60, 50, 40, 35, 25, 20],
                            backgroundColor: '#f0ad4e',
                            barPercentage: 0.5
                        },
                    ],
                },
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            stacked: false,
                            ticks: {
                                font: {
                                    size: 8
                                },
                                maxTicksLimit: 5
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 8
                                }
                            }
                        },
                    },
                },
            });

            // ── Evaluation Distribution Graph (stacked bar) ──
            new Chart(document.getElementById('evalDistChart'), {
                type: 'bar',
                data: {
                    labels: ['1', '2', '3', '4', '5'],
                    datasets: [{
                            label: '5 star',
                            data: [5, 10, 20, 35, 60],
                            backgroundColor: '#2ecc71'
                        },
                        {
                            label: '4 star',
                            data: [3, 8, 15, 25, 40],
                            backgroundColor: '#4a90d9'
                        },
                        {
                            label: '3 star',
                            data: [2, 5, 10, 15, 20],
                            backgroundColor: '#9b59b6'
                        },
                        {
                            label: '2 star',
                            data: [1, 3, 5, 8, 10],
                            backgroundColor: '#e8516a'
                        },
                        {
                            label: '1 star',
                            data: [1, 2, 3, 4, 5],
                            backgroundColor: '#95a5a6'
                        },
                    ],
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'left',
                            labels: {
                                font: {
                                    size: 8
                                },
                                boxWidth: 8,
                                padding: 4
                            },
                        },
                    },
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 8
                                }
                            }
                        },
                        y: {
                            stacked: true,
                            ticks: {
                                font: {
                                    size: 8
                                },
                                maxTicksLimit: 4
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                    },
                },
            });

            // ── Category Post Trend ──
            new Chart(document.getElementById('categoryTrendChart'), {
                type: 'line',
                data: {
                    labels: ['2024', '2025', '2026'],
                    datasets: [{
                            label: 'Cafe',
                            data: [200, 400, 800],
                            borderColor: '#4a90d9',
                            tension: 0.4,
                            fill: false,
                            pointRadius: 2
                        },
                        {
                            label: 'Cafe2',
                            data: [100, 300, 600],
                            borderColor: '#e8516a',
                            tension: 0.4,
                            fill: false,
                            pointRadius: 2
                        },
                        {
                            label: 'Restaurant',
                            data: [150, 250, 450],
                            borderColor: '#f0ad4e',
                            tension: 0.4,
                            fill: false,
                            pointRadius: 2
                        },
                        {
                            label: 'Events',
                            data: [50, 150, 300],
                            borderColor: '#5cb85c',
                            tension: 0.4,
                            fill: false,
                            pointRadius: 2
                        },
                    ],
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
                                    size: 9
                                }
                            }
                        },
                        y: {
                            ticks: {
                                font: {
                                    size: 9
                                },
                                maxTicksLimit: 5
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                    },
                },
            });

            // ── Reporting Breakdown (doughnut) ──
            new Chart(document.getElementById('reportingChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Inappropriate Content', 'Duplicate', 'Reports', 'Outdated'],
                    datasets: [{
                        data: [15, 8, 3, 3],
                        backgroundColor: ['#e8516a', '#4a90d9', '#5cb85c', '#f0ad4e'],
                        borderWidth: 1,
                    }],
                },
                options: {
                    cutout: '60%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                },
            });

            // ── Engagement Rate Trend ──
            new Chart(document.getElementById('engagementChart'), {
                type: 'line',
                data: {
                    labels: ['2024', '2025', '2026'],
                    datasets: [{
                        data: [10, 25, 45],
                        borderColor: '#4a90d9',
                        backgroundColor: 'rgba(74,144,217,0.08)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 3,
                    }],
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
                                    size: 9
                                }
                            }
                        },
                        y: {
                            min: 0,
                            max: 50,
                            ticks: {
                                font: {
                                    size: 9
                                },
                                maxTicksLimit: 6
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                    },
                },
            });

            // ── Activity Type Breakdown ──
            new Chart(document.getElementById('activityChart'), {
                type: 'bar',
                data: {
                    labels: ['Login', 'Review', 'Comment', 'Bookmark'],
                    datasets: [{
                        data: [160, 85, 130, 20],
                        backgroundColor: ['#4a90d9', '#e8516a', '#a0a0a0', '#f0ad4e'],
                        barPercentage: 0.6,
                    }],
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
                                    size: 9
                                }
                            }
                        },
                        y: {
                            ticks: {
                                font: {
                                    size: 9
                                },
                                maxTicksLimit: 5
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                    },
                },
            });
        </script>
    @endpush

@endsection
