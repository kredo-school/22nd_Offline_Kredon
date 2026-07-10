{{-- お知らせ --}}
@php
    $categoryBadgeMap = [
        'system'     => ['bg' => '#E6F1FB', 'color' => '#0C447C', 'icon' => 'fa-gear'],
        'comment'    => ['bg' => '#EAF3DE', 'color' => '#3B6D11', 'icon' => 'fa-comment'],
        'reply'      => ['bg' => '#EAF3DE', 'color' => '#3B6D11', 'icon' => 'fa-reply'],
        'like'       => ['bg' => '#FDEEF1', 'color' => '#A3275B', 'icon' => 'fa-heart'],
        'event'      => ['bg' => '#FFF4E0', 'color' => '#9A6700', 'icon' => 'fa-calendar-day'],
        'item_alert' => ['bg' => '#EEEDFE', 'color' => '#534AB7', 'icon' => 'fa-shop'],
        'digest'     => ['bg' => '#E6F1FB', 'color' => '#0C447C', 'icon' => 'fa-cubes'],
    ];
@endphp

<div class="hp-sticky-container">
    <div class="hp-notification-wrapper">
        <div class="hp-card">
            <div class="hp-card-header">
                <h6 class="hp-title">Notification</h6>
            </div>
            <div class="hp-scroll-area">
                @forelse($announcements as $announcement)
                    @php
                        $badge = $categoryBadgeMap[$announcement->category] ?? [
                            'bg' => '#F1F1F1', 'color' => '#555', 'icon' => 'fa-circle-info',
                        ];
                    @endphp
                    <div class="hp-notification-item">
                        <div class="hp-icon-wrap" style="background-color: {{ $badge['bg'] }}; color: {{ $badge['color'] }};">
                            <i class="fa-solid {{ $badge['icon'] }}"></i>
                        </div>
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
                    <div class="hp-empty-text">No notification</div>
                @endforelse
            </div>
            <div class="hp-card-footer">
                <a href="#"
                   class="hp-see-more"
                   data-bs-toggle="modal"
                   data-bs-target="#userNotificationsModal"
                   aria-label="お知らせをすべて表示">
                    View more
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <x-ranking-list type="game_score" />
        <x-ranking-list type="game_level" />
    </div>
</div>