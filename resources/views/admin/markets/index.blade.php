@extends('layouts.admin')

@section('title', 'Market Management')

@section('content')
    <div class="p-4" style="overflow-y: auto; height: 100%;">

        {{-- ── Header ── --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Market Management</h4>
                <p class="text-muted mb-0" style="font-size:0.85rem;">前の滞在者から譲り渡す出品を管理します</p>
            </div>
        </div>

        {{-- ── Metric Cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">総出品数</p>
                        <h4 class="fw-bold mb-0">124</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">要対応（通報）</p>
                        <h4 class="fw-bold mb-0 text-danger">3</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">出品中</p>
                        <h4 class="fw-bold mb-0">87</h4>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <p class="text-muted mb-1" style="font-size:0.78rem;">譲渡済み</p>
                        <h4 class="fw-bold mb-0 text-success">31</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Tabs ── --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom px-3 pt-3 pb-0">
                <ul class="nav nav-tabs card-header-tabs" id="marketTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="items-tab" data-bs-toggle="tab" data-bs-target="#items"
                            type="button" role="tab" style="font-size:0.85rem;">
                            出品一覧
                            <span class="badge bg-secondary ms-1" style="font-size:0.7rem;">87</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-danger" id="comments-tab" data-bs-toggle="tab"
                            data-bs-target="#comments" type="button" role="tab" style="font-size:0.85rem;">
                            コメント管理
                            <span class="badge bg-danger ms-1" style="font-size:0.7rem;">6</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="marketTabsContent">

                {{-- ══════════════════════════════════
                 出品一覧タブ
            ══════════════════════════════════ --}}
                <div class="tab-pane fade show active p-3" id="items" role="tabpanel">

                    {{-- Filters --}}
                    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                        <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0" placeholder="商品名・出品者名で検索">
                        </div>
                        <select class="form-select form-select-sm" style="width:auto;">
                            <option>Categories: All</option>
                            <option>Electronics</option>
                            <option>Clothes</option>
                            <option>消耗品</option>
                            <option>Others</option>
                        </select>
                        <select class="form-select form-select-sm" style="width:auto;">
                            <option>Status: All</option>
                            <option>出品中</option>
                            <option>譲渡済み</option>
                            <option>非公開</option>
                            <option>要確認</option>
                        </select>
                        <select class="form-select form-select-sm" style="width:auto;">
                            <option>新着順</option>
                            <option>コメント多い順</option>
                        </select>
                    </div>

                    {{-- Bulk actions --}}
                    <div class="d-flex align-items-center gap-2 mb-3" style="font-size:0.82rem;">
                        <span class="text-muted" id="selectedItemCount">0件選択中</span>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">公開</button>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">非公開</button>
                        <button class="btn btn-outline-danger btn-sm py-0 px-2">Delete</button>
                        <span class="ms-auto text-muted" style="font-size:0.78rem;">124件中 1-12件を表示</span>
                    </div>

                    {{-- ── Table ── --}}
                    @php
                        $items = [
                            [
                                'id' => 1,
                                'name' => 'MacBook 充電器',
                                'meta' => '家電・ほぼ未使用',
                                'category' => '家電',
                                'status' => '出品中',
                                'reports' => 0,
                                'views' => 1024,
                                'icon' => 'fa-laptop',
                                'flagged' => false,
                            ],
                            [
                                'id' => 2,
                                'name' => 'Tシャツ S/M サイズ',
                                'meta' => '衣類・2枚セット',
                                'category' => '衣類',
                                'status' => '出品中',
                                'reports' => 0,
                                'views' => 456,
                                'icon' => 'fa-shirt',
                                'flagged' => false,
                            ],
                            [
                                'id' => 3,
                                'name' => '日焼け止め・虫除けセット',
                                'meta' => '消耗品・残り半分',
                                'category' => '消耗品',
                                'status' => '譲渡済み',
                                'reports' => 1,
                                'views' => 312,
                                'icon' => 'fa-pump-soap',
                                'flagged' => false,
                            ],
                            [
                                'id' => 4,
                                'name' => '変換プラグ（EU型）',
                                'meta' => '家家・@david_i',
                                'category' => '家電',
                                'status' => '要確認',
                                'reports' => 2,
                                'views' => 78,
                                'icon' => 'fa-plug',
                                'flagged' => true,
                            ],
                            [
                                'id' => 5,
                                'name' => '変換プラグ（EU型）',
                                'meta' => '家電・写真不鮮明',
                                'category' => '消耗品',
                                'status' => '譲渡済み',
                                'reports' => 2,
                                'views' => 79,
                                'icon' => 'fa-plug',
                                'flagged' => false,
                            ],
                            [
                                'id' => 6,
                                'name' => 'Tシャツ S/M サイズ',
                                'meta' => '衣類',
                                'category' => '衣類',
                                'status' => '出品中',
                                'reports' => 0,
                                'views' => 201,
                                'icon' => 'fa-shirt',
                                'flagged' => false,
                            ],
                        ];
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:36px;">
                                        <input type="checkbox" class="form-check-input" id="selectAllItems">
                                    </th>
                                    <th style="width:44px;"></th>
                                    <th>Item</th>
                                    <th>User</th>
                                    <th style="width:100px;">Categories</th>
                                    <th style="width:120px;">Status</th>
                                    <th style="width: 100px;">Comment</th>
                                    <th style="width:70px;">Alert</th>
                                    <th style="width:80px;">Watched</th>
                                    <th style="width: 120px;">Date</th>
                                    <th style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    @php
                                        $statusConfig = match ($item['status']) {
                                            '出品中' => ['bg' => 'success'],
                                            '譲渡済み' => ['bg' => 'primary'],
                                            '非公開' => ['bg' => 'secondary'],
                                            '要確認' => ['bg' => 'danger'],
                                            default => ['bg' => 'secondary'],
                                        };
                                    @endphp
                                    <tr class="{{ $item['flagged'] ? 'table-danger' : '' }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input item-check">
                                        </td>
                                        <td>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width:36px;height:36px;">
                                                <i class="fa-solid {{ $item['icon'] }} text-secondary"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold" style="font-size:0.82rem;">{{ $item['name'] }}</div>
                                            <div class="text-muted" style="font-size:0.72rem;">{{ $item['meta'] }}</div>
                                        </td>
                                        <td>
                                            Username
                                        </td>
                                        <td class="text-muted">{{ $item['category'] }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $statusConfig['bg'] }} px-2 py-1"
                                                style="font-size:0.72rem;">
                                                @if ($item['status'] === '出品中')
                                                    <i class="fa-solid fa-circle-check me-1"
                                                        style="font-size:0.65rem;"></i>
                                                @elseif($item['status'] === '譲渡済み')
                                                    <i class="fa-solid fa-circle-info me-1"
                                                        style="font-size:0.65rem;"></i>
                                                @elseif($item['status'] === '要確認')
                                                    <i class="fa-solid fa-circle-exclamation me-1"
                                                        style="font-size:0.65rem;"></i>
                                                @endif
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                        <td class="text-muted text-center">
                                            {{-- コメント数のカウント --}}
                                            9
                                            {{-- @if ($item['comments_count'] > 0)
                                                <span class="fw-semibold text-dark">
                                                    <i class="fa-regular fa-comment text-secondary me-1"
                                                        style="font-size:0.75rem;"></i>
                                                    {{ number_format($item['comments_count']) }}
                                                </span>
                                            @else
                                                <span class="text-muted" style="opacity: 0.5;">0</span>
                                            @endif --}}
                                        </td>
                                        <td class="{{ $item['reports'] > 0 ? 'text-danger fw-semibold' : 'text-muted' }}">
                                            {{ $item['reports'] }}
                                        </td>
                                        <td class="text-muted">{{ number_format($item['views']) }}</td>
                                        <td>
                                            {{-- date --}}
                                            2025-05-23 18:30
                                        </td>
                                        <td>
                                            {{-- Action --}}
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.markets.show', $item['id']) }}"
                                                    class="btn btn-outline-secondary btn-sm py-0 px-2"
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

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted" style="font-size:0.78rem;">124件中 1-12件を表示</span>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link">‹</a></li>
                                <li class="page-item active"><a class="page-link">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">›</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                {{-- コメント管理タブ--}}
                <div class="tab-pane fade p-3" id="comments" role="tabpanel">

                    {{-- Filters --}}
                    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                        <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0" placeholder="コメント・ユーザー名で検索">
                        </div>
                        <select class="form-select form-select-sm" style="width:auto;">
                            <option>Status: All</option>
                            <option>承認済み</option>
                            <option>保留中</option>
                            <option>スパム</option>
                        </select>
                        <select class="form-select form-select-sm" style="width:auto;">
                            <option>Items: All</option>
                            <option>MacBook 充電器</option>
                            <option>変換プラグ（EU型）</option>
                        </select>
                    </div>

                    {{-- Bulk actions --}}
                    <div class="d-flex align-items-center gap-2 mb-3" style="font-size:0.82rem;">
                        <span class="text-muted" id="selectedCommentCount">0件選択中</span>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">Approve</button>
                        <button class="btn btn-outline-secondary btn-sm py-0 px-2">非表示</button>
                        <button class="btn btn-outline-danger btn-sm py-0 px-2">Delete</button>
                        <span class="ms-auto text-muted" style="font-size:0.78rem;">24件中 1-20件を表示</span>
                    </div>

                    {{-- Table --}}
                    @php
                        $comments = [
                            [
                                'text' => 'まだ出品中ですか？来週受け取れます！',
                                'item_name' => 'MacBook 充電器',
                                'item_id' => 1,
                                'handle' => '@john_cebu',
                                'date' => '2025-05-23 18:30',
                                'status' => '承認済み',
                            ],
                            [
                                'text' => 'サイズはSとMどちらが残ってますか？',
                                'item_name' => 'Tシャツ S/M サイズ',
                                'item_id' => 2,
                                'handle' => '@sarah_kim',
                                'date' => '2025-05-23 15:10',
                                'status' => '承認済み',
                            ],
                            [
                                'text' => 'これ本当に機能しますか？怪しいです。',
                                'item_name' => '変換プラグ（EU型）',
                                'item_id' => 4,
                                'handle' => '@anonymous',
                                'date' => '2025-05-22 12:45',
                                'status' => '保留中',
                            ],
                            [
                                'text' => 'http://spam-link.com 安く買えます！',
                                'item_name' => '変換プラグ（EU型）',
                                'item_id' => 4,
                                'handle' => '@system',
                                'date' => '2025-05-21 09:00',
                                'status' => 'スパム',
                            ],
                            [
                                'text' => '折り畳み方を教えてもらえますか？',
                                'item_name' => '折りたたみ傘',
                                'item_id' => 6,
                                'handle' => '@lisa_w',
                                'date' => '2025-05-20 14:20',
                                'status' => '承認済み',
                            ],
                        ];
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:32px;"><input type="checkbox" class="form-check-input"
                                            id="selectAllComments"></th>
                                    <th>コメント内容</th>
                                    <th style="width:160px;">対象商品</th>
                                    <th style="width:130px;">User</th>
                                    <th style="width:130px;">Date</th>
                                    <th style="width:80px;">Status</th>
                                    <th style="width:160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments as $comment)
                                    @php
                                        $statusBg = match ($comment['status']) {
                                            '承認済み' => 'success',
                                            '保留中' => 'warning',
                                            'スパム' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <tr>
                                        <td><input type="checkbox" class="form-check-input comment-check"></td>
                                        <td>{{ $comment['text'] }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center flex-shrink-0"
                                                    style="width:32px;height:32px;">
                                                    <i class="fa-solid fa-box fa-xs text-secondary"></i>
                                                </div>
                                                <span class="text-truncate" style="max-width:110px;">
                                                    {{ $comment['item_name'] }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    style="display:inline-flex;align-items:center;justify-content:center;
                                                     width:24px;height:24px;border-radius:50%;background:#dee2e6;
                                                     font-size:0.65rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                                    {{ strtoupper(substr(ltrim($comment['handle'], '@'), 0, 1)) }}
                                                </span>
                                                <span class="text-muted"
                                                    style="font-size:0.75rem;">{{ $comment['handle'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted text-nowrap">{{ $comment['date'] }}</td>
                                        <td>
                                            <span class="badge bg-{{ $statusBg }}" style="font-size:0.72rem;">
                                                {{ $comment['status'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.markets.show', $comment['item_id']) }}"
                                                    class="btn btn-outline-secondary btn-sm py-0 px-2"
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

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-end mt-3">
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link">‹</a></li>
                                <li class="page-item active"><a class="page-link">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">›</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // 出品一覧 全選択
            document.getElementById('selectAllItems')?.addEventListener('change', function() {
                document.querySelectorAll('.item-check').forEach(cb => cb.checked = this.checked);
                updateCount('.item-check', 'selectedItemCount');
            });
            document.querySelectorAll('.item-check').forEach(cb => {
                cb.addEventListener('change', () => updateCount('.item-check', 'selectedItemCount'));
            });

            // コメント管理 全選択
            document.getElementById('selectAllComments')?.addEventListener('change', function() {
                document.querySelectorAll('.comment-check').forEach(cb => cb.checked = this.checked);
                updateCount('.comment-check', 'selectedCommentCount');
            });
            document.querySelectorAll('.comment-check').forEach(cb => {
                cb.addEventListener('change', () => updateCount('.comment-check', 'selectedCommentCount'));
            });

            function updateCount(selector, counterId) {
                const count = document.querySelectorAll(selector + ':checked').length;
                const el = document.getElementById(counterId);
                if (el) el.textContent = count + '件選択中';
            }
        </script>
    @endpush

@endsection
