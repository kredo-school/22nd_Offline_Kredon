{{-- お知らせ --}}
<div class="sticky-top" style="top: 85px;">
    <div class="card border-0 shadow-sm mb-3" style="height: 280px">
        <div class="card-body overflow-auto">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-bold mb-0">お知らせ</h6>
                <a href="#" class="text-decoration-none small">すべて見る</a>
            </div>

            @forelse($notifications as $notification)
                <div class="d-flex align-items-start mb-3">
                    <div class="me-3">
                        <i class="fa-solid fa-circle-info text-primary fs-4"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $notification->title }}</div>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="ms-2 flex-shrink-0">
                        <img src="{{ $notification->image_url ?? 'https://placehold.co/45x45' }}" class="rounded" style="width: 45px; height: 45px; object-fit: cover;">
                    </div>
                </div>
                @if (!$loop->last)<hr class="my-2 text-muted">@endif
            @empty
                <div class="text-center mt-5 text-muted">お知らせはありません</div>
            @endforelse
        </div>
    </div>
</div>

{{-- 今週のイベント --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold align-items-center mb-0">注目イベント</h6>
            <a href="#" class="text-decoration-none">すべて見る</a>
        </div>
        
        {{-- コントローラーから渡された $events をループ --}}
        @forelse($events as $event)
            <div class="d-flex mb-3">
                {{-- 画像エリア：データベースのパスを使用 --}}
                <div class="flex-shrink-0">
                    <img src="{{ $event->image_path ? asset('storage/' . $event->image_path) : 'https://placehold.co/80x80' }}"
                         class="rounded"
                         alt="{{ $event->title }}"
                         style="width: 80px; height: 80px; object-fit: cover;">
                </div>

                {{-- テキストエリア：オブジェクトプロパティとしてアクセス --}}
                <div class="ms-3">
                    <div class="fw-semibold text-dark">
                        {{ $event->title }}
                    </div>
                    <small class="text-muted d-block">
                        {{-- Carbonを使って日付をフォーマット --}}
                        {{ \Carbon\Carbon::parse($event->start_date)->format('Y/m/d (D) H:i') }}
                    </small>
                    <small class="text-muted">
                        {{ $event->location }}
                    </small>
                </div>            
            </div>

            @if (!$loop->last)
                <hr class="my-2 text-muted">
            @endif
        @empty
            <div class="text-center text-muted py-3">イベントはありません</div> 
        @endforelse
    </div>
</div>