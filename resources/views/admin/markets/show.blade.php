@extends('layouts.admin')

@section('title', '商品詳細')

@section('content')
<div class="p-4" style="overflow-y: auto; height: 100%;">

    {{-- ── Breadcrumb ── --}}
    <nav class="mb-3" style="font-size:0.82rem;">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.markets.index') }}" class="text-decoration-none">Market</a>
            </li>
            <li class="breadcrumb-item active">商品詳細</li>
        </ol>
    </nav>

    {{-- ── Header ── --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">{{ $item['name'] }}</h4>
            <p class="text-muted mb-0" style="font-size:0.85rem;">
                {{ $item['category'] }} · 投稿日: {{ $item['posted_at'] }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3">Edit</button>
            <button class="btn btn-outline-danger btn-sm px-3">Delete</button>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── Left Column: 商品情報 ── --}}
        <div class="col-12 col-lg-7">

            {{-- Photos --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">写真</h6>
                    {{-- Main photo --}}
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-2"
                         style="height:260px;">
                        <i class="fa-solid fa-image fa-3x text-secondary"></i>
                    </div>
                    {{-- Thumbnails --}}
                    <div class="d-flex gap-2">
                        @for($i = 0; $i < 4; $i++)
                        <div class="bg-light rounded d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:68px;height:68px;cursor:pointer;
                                    {{ $i === 0 ? 'border:2px solid #212529;' : '' }}">
                            <i class="fa-solid fa-image text-secondary" style="font-size:1.2rem;"></i>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Item info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">商品情報</h6>
                    <table class="table table-sm mb-0" style="font-size:0.85rem;">
                        <tbody>
                            <tr>
                                <td class="text-muted" style="width:120px;">商品名</td>
                                <td class="fw-medium">{{ $item['name'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">カテゴリー</td>
                                <td>{{ $item['category'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">状態</td>
                                <td>{{ $item['condition'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">ステータス</td>
                                <td>
                                    @php
                                    $statusBg = match($item['status']) {
                                        '出品中'   => 'success',
                                        '譲渡済み' => 'primary',
                                        '非公開'   => 'secondary',
                                        '要確認'   => 'danger',
                                        default    => 'secondary',
                                    };
                                    @endphp
                                    <span class="badge bg-{{ $statusBg }}">{{ $item['status'] }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">投稿日</td>
                                <td>{{ $item['posted_at'] }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">受け渡し場所</td>
                                <td>{{ $item['location'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Description --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">説明文</h6>
                    <p class="mb-0" style="font-size:0.85rem;line-height:1.7;">
                        {{ $item['description'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- ── Right Column: 出品者 & コメント ── --}}
        <div class="col-12 col-lg-5">

            {{-- Seller info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3">出品者</h6>
                    <div class="d-flex align-items-center gap-3">
                        <span style="display:inline-flex;align-items:center;justify-content:center;
                                     width:44px;height:44px;border-radius:50%;background:#dee2e6;
                                     font-size:1rem;font-weight:bold;color:#495057;flex-shrink:0;">
                            {{ strtoupper(substr($item['user'], 0, 1)) }}
                        </span>
                        <div>
                            <div class="fw-medium">{{ $item['user'] }}</div>
                            <div class="text-muted" style="font-size:0.78rem;">{{ $item['handle'] }}</div>
                        </div>
                        <a href="#" class="btn btn-outline-secondary btn-sm ms-auto py-0 px-2"
                           style="font-size:0.75rem;">プロフィール</a>
                    </div>
                </div>
            </div>

            {{-- Comments --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">
                            コメント
                            <span class="badge bg-secondary ms-1" style="font-size:0.72rem;">
                                {{ count($item['comments']) }}
                            </span>
                        </h6>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" style="width:auto;font-size:0.75rem;">
                                <option>All</option>
                                <option>Approved</option>
                                <option>Suspended</option>
                                <option>Spam</option>
                            </select>
                        </div>
                    </div>

                    {{-- Comment list --}}
                    <div class="d-flex flex-column gap-3">
                        @foreach($item['comments'] as $comment)
                        @php
                        $statusBg = match($comment['status']) {
                            '承認済み' => 'success',
                            '保留中'   => 'warning',
                            'スパム'   => 'danger',
                            default    => 'secondary',
                        };
                        @endphp
                        <div class="p-2 rounded {{ $comment['status'] === 'スパム' ? 'bg-danger bg-opacity-10 border border-danger border-opacity-25' : 'bg-light' }}">
                            {{-- Comment header --}}
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span style="display:inline-flex;align-items:center;justify-content:center;
                                             width:28px;height:28px;border-radius:50%;background:#dee2e6;
                                             font-size:0.7rem;font-weight:bold;color:#495057;flex-shrink:0;">
                                    {{ strtoupper(substr($comment['user'], 0, 1)) }}
                                </span>
                                <div class="flex-grow-1">
                                    <span class="fw-medium" style="font-size:0.78rem;">{{ $comment['user'] }}</span>
                                    <span class="text-muted ms-1" style="font-size:0.72rem;">{{ $comment['handle'] }}</span>
                                </div>
                                <span class="badge bg-{{ $statusBg }}" style="font-size:0.65rem;">
                                    {{ $comment['status'] }}
                                </span>
                            </div>
                            {{-- Comment body --}}
                            <p class="mb-2" style="font-size:0.82rem;">{{ $comment['text'] }}</p>
                            {{-- Comment footer --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted" style="font-size:0.72rem;">{{ $comment['date'] }}</span>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2"
                                            style="font-size:0.68rem;">Edit</button>
                                    <button class="btn btn-outline-danger btn-sm py-0 px-2"
                                            style="font-size:0.68rem;">Delete</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection