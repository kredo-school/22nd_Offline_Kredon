<div class="hp-post-card">
    <div class="hp-post-header">
        <img src="{{ $item->user?->avatarUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($item->user?->name ?? 'User') }}"
             class="hp-avatar" alt="avatar">
        <div>
            <div class="hp-user-name">{{ $item->user?->name ?? '匿名' }}</div>
            <div class="hp-post-date">{{ $item->created_at->diffForHumans() }}</div>
        </div>
    </div>

    <a href="{{ $item->url ?? '#' }}" class="text-decoration-none text-reset">
        <div class="hp-post-image-wrap">
            <img src="{{ $item->image_url ?? asset('images/welcome-bg.jpg') }}"
                 class="hp-post-image" alt="{{ $item->title }}">
        </div>

        <div class="hp-post-body">
            <h6 class="hp-post-title">{{ $item->title }}</h6>
            <p class="hp-post-description">{{ $item->description }}</p>
        </div>
    </a>

    <div class="hp-post-footer">
        <a href="{{ $item->url ?? '#' }}" class="hp-comment-link">詳細を見る</a>
    </div>
</div>
