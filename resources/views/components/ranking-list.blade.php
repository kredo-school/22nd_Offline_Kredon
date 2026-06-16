<div class="kk-card">
    <div class="kk-card-header">
        <h6 class="kk-title">{{ $title }}</h6>
    </div>

    <div class="kk-ranking-list">
        @forelse($items as $index => $item)
            <div class="kk-ranking-item">
                <span class="kk-rank-number">{{ $index + 1 }}</span>
                <div class="kk-rank-content">
                    <div class="kk-rank-title">{{ $item->title }}</div>
                    <div class="small kk-rank-meta">
                        {{ $item->value }} {{ $metric }}
                    </div>
                </div>
            </div>
        @empty
            <div class="kk-empty-text">データがありません</div>
        @endforelse
    </div>
</div>
