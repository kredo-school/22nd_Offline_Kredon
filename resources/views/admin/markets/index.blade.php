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
        {{-- <a href="#" class="btn btn-dark btn-sm px-3">
            <i class="fa-solid fa-plus me-1"></i> 新規出品
        </a> --}}
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
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <p class="text-muted mb-1" style="font-size:0.78rem;">要確認</p>
                    <h4 class="fw-bold mb-0 text-danger">6</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Tabs ── --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom px-3 pt-3 pb-0">
            <ul class="nav nav-tabs card-header-tabs" id="marketTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="items-tab"
                            data-bs-toggle="tab" data-bs-target="#items"
                            type="button" role="tab" style="font-size:0.85rem;">
                        出品一覧
                        <span class="badge bg-secondary ms-1" style="font-size:0.7rem;">87</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="comments-tab"
                            data-bs-toggle="tab" data-bs-target="#comments"
                            type="button" role="tab" style="font-size:0.85rem;">
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
                        <input type="text" class="form-control bg-light border-0"
                               placeholder="商品名・出品者名で検索">
                    </div>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>カテゴリー: すべて</option>
                        <option>家電</option>
                        <option>衣類</option>
                        <option>食品・消耗品</option>
                        <option>その他</option>
                    </select>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>ステータス: すべて</option>
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
                    <span class="text-muted">0件選択中</span>
                    <button class="btn btn-outline-secondary btn-sm py-0 px-2">公開</button>
                    <button class="btn btn-outline-secondary btn-sm py-0 px-2">非公開</button>
                    <button class="btn btn-outline-danger btn-sm py-0 px-2">削除</button>
                    <span class="ms-auto text-muted" style="font-size:0.78rem;">124件中 1-12件を表示</span>
                </div>

                {{-- Item Grid --}}
                @php
                $items = [
                    ['id'=>1,'name'=>'MacBook 充電器','category'=>'家電','condition'=>'ほぼ未使用','user'=>'Maria Santos','handle'=>'@maria_cebu','status'=>'出品中','comments'=>3,'icon'=>'fa-laptop'],
                    ['id'=>2,'name'=>'Tシャツ S/M サイズ','category'=>'衣類','condition'=>'2枚セット','user'=>'John Dela Cruz','handle'=>'@john_cebu','status'=>'出品中','comments'=>1,'icon'=>'fa-shirt'],
                    ['id'=>3,'name'=>'日焼け止め・虫除けセット','category'=>'消耗品','condition'=>'残り半分','user'=>'Sarah Kim','handle'=>'@sarah_kim','status'=>'譲渡済み','comments'=>0,'icon'=>'fa-pump-soap'],
                    ['id'=>4,'name'=>'変換プラグ（EU型）','category'=>'家電','condition'=>'写真不鮮明','user'=>'David Lee','handle'=>'@david_t','status'=>'要確認','comments'=>2,'icon'=>'fa-plug'],
                    ['id'=>5,'name'=>'ガイドブック セブ島','category'=>'その他','condition'=>'書き込みなし','user'=>'Lisa Wong','handle'=>'@lisa_w','status'=>'出品中','comments'=>0,'icon'=>'fa-book'],
                    ['id'=>6,'name'=>'折りたたみ傘','category'=>'その他','condition'=>'1回使用','user'=>'Mike Tan','handle'=>'@mike_t','status'=>'出品中','comments'=>1,'icon'=>'fa-umbrella'],
                ];
                @endphp

                <div class="row g-3">
                    @foreach($items as $item)
                    @php
                    $statusConfig = match($item['status']) {
                        '出品中'   => ['bg' => 'success', 'text' => 'success'],
                        '譲渡済み' => ['bg' => 'primary', 'text' => 'primary'],
                        '非公開'   => ['bg' => 'secondary','text' => 'secondary'],
                        '要確認'   => ['bg' => 'danger',  'text' => 'danger'],
                        default    => ['bg' => 'secondary','text' => 'secondary'],
                    };
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 border {{ $item['status'] === '要確認' ? 'border-danger' : '' }} shadow-sm">
                            {{-- Image placeholder --}}
                            <div class="position-relative">
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height:130px;">
                                    <i class="fa-solid {{ $item['icon'] }} fa-2x text-secondary"></i>
                                </div>
                                <span class="position-absolute top-0 start-0 m-2 badge bg-{{ $statusConfig['bg'] }}"
                                      style="font-size:0.68rem;">
                                    {{ $item['status'] }}
                                </span>
                                <input type="checkbox" class="position-absolute top-0 end-0 m-2">
                            </div>
                            <div class="card-body p-2">
                                <p class="fw-semibold mb-1" style="font-size:0.82rem;">{{ $item['name'] }}</p>
                                <p class="text-muted mb-2" style="font-size:0.72rem;">
                                    {{ $item['category'] }} · {{ $item['condition'] }}
                                </p>
                                {{-- User --}}
                                <div class="d-flex align-items-center gap-1 mb-2">
                                    <span style="display:inline-flex;align-items:center;justify-content:center;
                                                 width:20px;height:20px;border-radius:50%;background:#dee2e6;
                                                 font-size:0.65rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                        {{ strtoupper(substr($item['user'], 0, 1)) }}
                                    </span>
                                    <span class="text-muted" style="font-size:0.72rem;">{{ $item['handle'] }}</span>
                                    @if($item['comments'] > 0)
                                    <span class="ms-auto badge bg-light text-muted border"
                                          style="font-size:0.65rem;">
                                        <i class="fa-regular fa-comment fa-xs"></i> {{ $item['comments'] }}
                                    </span>
                                    @endif
                                </div>
                                {{-- Actions --}}
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.markets.show', $item['id']) }}"
                                       class="btn btn-outline-secondary btn-sm py-0 px-2 flex-fill"
                                       style="font-size:0.72rem;">詳細</a>
                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2 flex-fill"
                                            style="font-size:0.72rem;">Edit</button>
                                    <button class="btn btn-outline-danger btn-sm py-0 px-2 flex-fill"
                                            style="font-size:0.72rem;">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
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

            {{-- ══════════════════════════════════
                 コメント管理タブ
            ══════════════════════════════════ --}}
            <div class="tab-pane fade p-3" id="comments" role="tabpanel">

                {{-- Filters --}}
                <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                    <div class="input-group input-group-sm flex-grow-1" style="max-width:280px;">
                        <span class="input-group-text bg-light border-0">
                            <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                        </span>
                        <input type="text" class="form-control bg-light border-0"
                               placeholder="コメント・ユーザー名で検索">
                    </div>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>ステータス: すべて</option>
                        <option>承認済み</option>
                        <option>保留中</option>
                        <option>スパム</option>
                    </select>
                    <select class="form-select form-select-sm" style="width:auto;">
                        <option>商品: すべて</option>
                        <option>MacBook 充電器</option>
                        <option>変換プラグ（EU型）</option>
                    </select>
                </div>

                {{-- Bulk actions --}}
                <div class="d-flex align-items-center gap-2 mb-3" style="font-size:0.82rem;">
                    <span class="text-muted">0件選択中</span>
                    <button class="btn btn-outline-secondary btn-sm py-0 px-2">承認</button>
                    <button class="btn btn-outline-secondary btn-sm py-0 px-2">非表示</button>
                    <button class="btn btn-outline-danger btn-sm py-0 px-2">削除</button>
                    <span class="ms-auto text-muted" style="font-size:0.78rem;">24件中 1-20件を表示</span>
                </div>

                {{-- Table --}}
                @php
                $comments = [
                    ['text'=>'まだ出品中ですか？来週受け取れます！','item_name'=>'MacBook 充電器','item_id'=>1,'user'=>'John Dela Cruz','handle'=>'@john_cebu','date'=>'2025-05-23 18:30','status'=>'承認済み'],
                    ['text'=>'サイズはSとMどちらが残ってますか？','item_name'=>'Tシャツ S/M サイズ','item_id'=>2,'user'=>'Sarah Kim','handle'=>'@sarah_kim','date'=>'2025-05-23 15:10','status'=>'承認済み'],
                    ['text'=>'これ本当に機能しますか？怪しいです。','item_name'=>'変換プラグ（EU型）','item_id'=>4,'user'=>'Anonymous','handle'=>'@anonymous','date'=>'2025-05-22 12:45','status'=>'保留中'],
                    ['text'=>'http://spam-link.com 安く買えます！','item_name'=>'変換プラグ（EU型）','item_id'=>4,'user'=>'System','handle'=>'@system','date'=>'2025-05-21 09:00','status'=>'スパム'],
                    ['text'=>'折り畳み方を教えてもらえますか？','item_name'=>'折りたたみ傘','item_id'=>6,'user'=>'Lisa Wong','handle'=>'@lisa_w','date'=>'2025-05-20 14:20','status'=>'承認済み'],
                ];
                @endphp

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size:0.82rem;">
                        <thead class="table-light">
                            <tr>
                                <th style="width:32px;"><input type="checkbox"></th>
                                <th>コメント内容</th>
                                <th style="width:160px;">対象商品</th>
                                <th style="width:130px;">ユーザー</th>
                                <th style="width:130px;">投稿日</th>
                                <th style="width:80px;">ステータス</th>
                                <th style="width:140px;">アクション</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comments as $comment)
                            @php
                            $statusBg = match($comment['status']) {
                                '承認済み' => 'success',
                                '保留中'   => 'warning',
                                'スパム'   => 'danger',
                                default    => 'secondary',
                            };
                            @endphp
                            <tr>
                                <td><input type="checkbox"></td>
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
                                        <span style="display:inline-flex;align-items:center;justify-content:center;
                                                     width:24px;height:24px;border-radius:50%;background:#dee2e6;
                                                     font-size:0.65rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                            {{ strtoupper(substr($comment['user'], 0, 1)) }}
                                        </span>
                                        <span class="text-muted" style="font-size:0.75rem;">{{ $comment['handle'] }}</span>
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
@endsection