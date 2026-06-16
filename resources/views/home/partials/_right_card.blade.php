{{-- お知らせ --}}
<div class="kk-sticky-contaier">
    <div class="kk-notification-wrapper">
        <div class="kk-card">
            <div class="kk-card-header">
                <h6 class="kk-title">お知らせ</h6>
                <a href="#" class="kk-link">もっと見る</a>
            </div>
            <div class="kk-scroll-area">
                @forelse($notifications as $notification)
                    <div class="kk-notification-item">
                        <div class="kk-icon-wrap"><i class="fa-solid fa-circle-info"></i></div>
                        <div class="kk-content-wrap">
                            <div class="kk-item-title">{{ $notification->title }}</div>
                            <small class="kk-item-date">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="kk-image-wrap">
                            <img src="{{ $notification->image_url ?? 'https://placehold.co/45/45' }}" alt="icon">
                        </div>
                    </div>
                    @if (!$loop->last) <div class="kk-divider"></div> @endif
                @empty
                    <div class="kk-empty-text">お知らせはありません</div>
                @endforelse
            </div>
        </div>

        {{-- コンポーネント化したランキングを配置 --}}
        <x-ranking-list type="market" />
        <x-ranking-list type="game_score" />
        <x-ranking-list type="spot" />
    </div>
</div>