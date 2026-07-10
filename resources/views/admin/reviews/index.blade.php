@extends('layouts.admin')

@section('title', 'Review Management')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">

        {{-- ── Header ── --}}
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h4 class="fw-bold mb-1">Review Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">You can manage and moderate reviews for Spot.</p>
            </div>
        </div>

        {{-- ── Category Tabs (metric style) ── --}}
        <div class="row g-0 mb-4 border-0 rounded overflow-hidden shadow-sm">
            @php
                $tabs = [
                    [
                        'label' => 'All reviews',
                        'count' => '2,104',
                        'key' => 'all',
                        'active' => true,
                        'danger' => false,
                    ],
                    ['label' => 'Working spots', 'count' => '1,456', 'key' => 'spot', 'active' => false, 'danger' => false],
                    ['label' => 'Tourism spots', 'count' => '648', 'key' => 'event', 'active' => false, 'danger' => false],
                    ['label' => 'Needs attention', 'count' => '18', 'key' => 'pending', 'active' => false, 'danger' => true],
                ];
            @endphp
            @foreach ($tabs as $tab)
                <div class="col-6 col-md-3 g-3">
                    <a href="?tab={{ $tab['key'] }}"
                        class="d-block p-3 text-decoration-none h-100 {{ $tab['active'] ? 'bg-dark text-white' : 'bg-white' }} {{ !$loop->last ? 'border-end' : '' }}">
                        <p class="mb-1"
                            style="font-size:0.75rem; opacity: {{ $tab['active'] ? '0.7' : '1' }}; color: {{ $tab['active'] ? '#fff' : '#6c757d' }};">
                            {{ $tab['label'] }}
                        </p>
                        <h4
                            class="fw-bold mb-0 {{ $tab['danger'] ? 'text-danger' : ($tab['active'] ? 'text-white' : '') }}">
                            {{ $tab['count'] }}
                        </h4>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- ── Table Card ── --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">

                {{-- ── Filters ── --}}
                <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                    <div class="input-group input-group-sm flex-grow-1" style="max-width:320px;">
                        <span class="input-group-text bg-light border-0">
                            <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0" placeholder="Search by Review, Username, or Subject Name">
                    </div>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>Rating: All</option>
                        <option>★★★★★ (5)</option>
                        <option>★★★★ (4)</option>
                        <option>★★★ (3)</option>
                        <option>★★ (2)</option>
                        <option>★ (1)</option>
                    </select>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>Category: All</option>
                        <optgroup label="Working spots">
                            <option value="spot_working">　Working</option>
                            <option value="spot_tourism">　Tourism</option>
                        </optgroup>
                        <optgroup label="Tourism spots">
                            <option value="event">　Event</option>
                        </optgroup>
                    </select>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>Status: All</option>
                        <option>Approved</option>
                        <option>Suspended</option>
                        <option>Hidden</option>
                    </select>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>Over the past 30 days</option>
                        <option>Over the past 7 days</option>
                        <option>Over the past 90 days間</option>
                    </select>
                </div>

                {{-- ── Bulk Actions ── --}}
                <div class="d-flex align-items-center gap-2 mb-3" style="font-size:0.82rem;">
                    <span class="text-muted">0件選択中</span>
                    <button class="btn btn-outline-secondary btn-sm py-0 px-2">Approved</button>
                    <button class="btn btn-outline-secondary btn-sm py-0 px-2">Hidden</button>
                    <button class="btn btn-outline-danger btn-sm py-0 px-2">Delete</button>
                    <span class="ms-auto text-muted" style="font-size:0.78rem;">2,104件中 1-20件を表示</span>
                </div>

                {{-- ── Table ── --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width:32px;">
                                    <input type="checkbox" class="form-check-input" id="selectAllreviews">
                                </th>
                                <th>Content</th>
                                <th style="width:100px;">Evaluation</th>
                                <th style="width:90px;">Categories</th>
                                <th style="width:110px;">User</th>
                                <th style="width:120px;">Post day</th>
                                <th style="width:80px;">Status</th>
                                <th style="width:120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- ダミーデータ（実際はforeachに差し替え） --}}
                            @php
                                $reviews = [
                                    [
                                        'text' => '景色が最高でした！また来たいです。',
                                        'target' => 'Tops Mountain',
                                        'stars' => 5,
                                        'category' => 'spot_tourism',
                                        'user' => 'Maria Santos',
                                        'handle' => '@maria_cebu',
                                        'date' => '2025-05-23 18:30',
                                        'status' => '承認済み',
                                    ],
                                    [
                                        'text' => 'イベントの運営が素晴らしかったです！主催者の方々に感謝します。',
                                        'target' => 'CEBU FOOD FEST 2025',
                                        'stars' => 4,
                                        'category' => 'event',
                                        'user' => 'John Dela Cruz',
                                        'handle' => '@john_cebu',
                                        'date' => '2025-05-23 17:45',
                                        'status' => '承認済み',
                                    ],
                                    [
                                        'text' => 'セブのビーチは最高です！また絶対に来ます！',
                                        'target' => 'Mactan Beach',
                                        'stars' => 5,
                                        'category' => 'spot_working',
                                        'user' => 'David Lee',
                                        'handle' => '@david_traveler',
                                        'date' => '2025-05-23 16:20',
                                        'status' => '承認済み',
                                    ],
                                    [
                                        'text' => '情報ありがとうございます！とても参考になりました。',
                                        'target' => 'WEEKLY RUN CLUB',
                                        'stars' => 4,
                                        'category' => 'event',
                                        'user' => 'Sarah Kim',
                                        'handle' => '@sarah_kim',
                                        'date' => '2025-05-23 15:10',
                                        'status' => '保留中',
                                    ],
                                    [
                                        'text' => '最悪でした。二度と行かない。',
                                        'target' => 'Ayala Mall',
                                        'stars' => 1,
                                        'category' => 'spot_hospital',
                                        'user' => 'Anonymous User',
                                        'handle' => '@anonymous',
                                        'date' => '2025-05-22 14:30',
                                        'status' => '保留中',
                                    ],
                                    [
                                        'text' => '不適切な表現が含まれています。運営に報告します。',
                                        'target' => 'LANGUAGE EXCHANGE',
                                        'stars' => 2,
                                        'category' => 'event',
                                        'user' => 'System',
                                        'handle' => '@system',
                                        'date' => '2025-05-21 09:15',
                                        'status' => '非表示',
                                    ],
                                ];
                            @endphp

                            @foreach ($reviews as $review)
                                @php
                                    $statusBg = match ($review['status']) {
                                        'Approved' => 'success',
                                        'Pending' => 'warning',
                                        'Not indicated' => 'secondary',
                                        default => 'secondary',
                                    };
                                    $categoryConfig = match ($review['category']) {
                                        'spot_working' => ['label' => 'Working', 'bg' => 'success'],
                                        'spot_tourism' => ['label' => 'Tourism', 'bg' => 'success'],
                                        // 'event' => ['label' => 'Tourism spots', 'bg' => 'primary'],
                                        default => ['label' => 'Others', 'bg' => 'secondary'],
                                    };
                                @endphp
                                <tr>
                                    <td><input type="checkbox" style="form-check-input item-check"></td>
                                    <td>
                                        <div class="fw-medium mb-1">{{ $review['text'] }}</div>
                                        <div class="text-muted" style="font-size:0.75rem;">
                                            Target: {{ $review['target'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-warning">
                                            @for ($i = 1; $i <= 5; $i++)
                                                {{ $i <= $review['stars'] ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $categoryConfig['bg'] }}-subtle
                                             text-{{ $categoryConfig['bg'] }}-emphasis
                                             border border-{{ $categoryConfig['bg'] }}-subtle"
                                            style="font-size:0.72rem;">
                                            {{ $categoryConfig['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span
                                                style="display:inline-flex;align-items:center;justify-content:center;
                                                 width:28px;height:28px;border-radius:50%;background:#dee2e6;
                                                 font-size:0.7rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                                {{ strtoupper(substr($review['user'], 0, 1)) }}
                                            </span>
                                            <div>
                                                <div style="font-size:0.78rem;">{{ $review['user'] }}</div>
                                                <div class="text-muted" style="font-size:0.7rem;">{{ $review['handle'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-nowrap text-muted">{{ $review['date'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $statusBg }}" style="font-size:0.72rem;">
                                            {{ $review['status'] }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="#" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                style="font-size:0.72rem;">Detail</a>
                                            <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                                style="font-size:0.72rem;">Edit</button>
                                            <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                                style="font-size:0.72rem;">Delete</button>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ── Pagination ── --}}
                <div class="d-flex justify-content-end mt-3">
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link">‹</a></li>
                            <li class="page-item active"><a class="page-link">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">106</a></li>
                            <li class="page-item"><a class="page-link" href="#">›</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // review一覧 全選択
        document.getElementById('selectAllreviews')?.addEventListener('change', function() {
            document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
            updateCount('.item-check', 'selectedItemCount');
        });
        document.querySelectorAll('.item-check').forEach(cb => {
            cb.addEventListener('change', () => updateCount('.item-check', 'selectedItemCount'));
        });
    </script>
@endpush
