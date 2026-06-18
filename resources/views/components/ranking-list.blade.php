<div class="hp-ranking-card">
    <div class="hp-card-header">
        <h5 class="hp-section-title">{{ $title }}</h5>
    </div>

    @forelse($items as $item)
        {{-- 2. 個別のアイテム --}}
        <div class="hp-ranking-item">
            <div class="hp-rank-icon">
                @if($loop->first)
                    <i class="fa-solid fa-crown rank-gold"></i>
                @elseif($loop->iteration == 2)
                    <i class="fa-solid fa-medal rank-silver"></i>
                @elseif($loop->iteration == 3)
                    <i class="fa-solid fa-award rank-bronze"></i>
                @else
                    <span class="hp-rank-number">{{ $loop->iteration }}</span>
                @endif
            </div>

            <div class="hp-rank-content">
                <div class="hp-rank-title">{{ $item->title }}</div>
                <div class="small hp-rank-meta">
                    {{ $item->value }} {{ $metric }} 
                    <span class="text-muted">| 参加者: {{ $item->participants_count ?? 0 }}名</span>
                </div>
            </div>

            <div class="hp-rank-action">
                <a href="#" class="hp-btn-sm">詳細</a>
            </div>
        </div>
    @empty
        <div class="hp-empty-text">データがありません</div>
    @endforelse
</div>