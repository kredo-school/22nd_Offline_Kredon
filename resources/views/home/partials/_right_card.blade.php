{{-- お知らせ --}}
<div class="hp-sticky-container">
    <div class="hp-notification-wrapper">
        <div class="hp-card">
            <div class="hp-card-header">
                <h6 class="hp-title">お知らせ</h6>
            </div>
            <div class="hp-scroll-area">
                @forelse($announcements as $announcement)
                    <div class="hp-notification-item">
                        <div class="hp-icon-wrap"><i class="fa-solid fa-circle-info"></i></div>
                        <div class="hp-content-wrap">
                            @if ($announcement->url)
                                <a href="{{ $announcement->url }}" class="hp-item-title text-decoration-none text-reset">
                                    {{ $announcement->title }}
                                </a>
                            @else
                                <div class="hp-item-title">{{ $announcement->title }}</div>
                            @endif
                            <small class="hp-item-date">{{ $announcement->created_at->diffForHumans() }}</small>
                        </div>
                        @if ($announcement->image_url)
                            <div class="hp-image-wrap">
                                <img src="{{ $announcement->image_url }}" alt="icon">
                            </div>
                        @endif
                    </div>
                    @if (!$loop->last) <div class="hp-divider"></div> @endif
                @empty
                    <div class="hp-empty-text">お知らせはありません</div>
                @endforelse
            </div>
            <div class="hp-card-footer">
                <a href="#"
                   class="hp-see-more"
                   data-bs-toggle="modal"
                   data-bs-target="#userNotificationsModal"
                   aria-label="お知らせをすべて表示">
                    もっと見る
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <x-ranking-list type="game_score" />
        <x-ranking-list type="game_level" />
    </div>
</div>
