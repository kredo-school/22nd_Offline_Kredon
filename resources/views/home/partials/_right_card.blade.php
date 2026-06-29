{{-- お知らせ --}}
<div class="hp-sticky-container">
    <div class="hp-notification-wrapper">
        <div class="hp-card">
            <div class="hp-card-header">
                <h6 class="hp-title">お知らせ</h6>
                <a href="#" class="hp-link">もっと見る</a>
            </div>
            <div class="hp-scroll-area">
                @forelse($notifications as $notification)
                    <div class="hp-notification-item">
                        <div class="hp-icon-wrap"><i class="fa-solid fa-circle-info"></i></div>
                        <div class="hp-content-wrap">
                            <div class="hp-item-title">{{ $notification->title }}</div>
                            <small class="hp-item-date">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="hp-image-wrap">
                            <img src="{{ $notification->image_url ?? 'https://placehold.co/45/45' }}" alt="icon">
                        </div>
                    </div>
                    @if (!$loop->last) <div class="hp-divider"></div> @endif
                @empty
                    <div class="hp-empty-text">お知らせはありません</div>
                @endforelse
            </div>
        </div>

        {{-- コンポーネント化したランキングを配置 --}}
        <x-ranking-list type="game_score" />
        <x-ranking-list type="game_level" />
    </div>
</div>