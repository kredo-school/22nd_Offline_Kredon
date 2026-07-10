<div class="hp-post-card">
    <div class="hp-post-header">
        <img src="{{ $item->user?->avatarUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($item->user?->name ?? 'User') }}"
            class="hp-avatar" alt="avatar">
        <div>
            <div class="hp-user-name">{{ $item->user?->name ?? 'Anonymous' }}</div>
            <div class="hp-post-date">{{ $item->created_at->diffForHumans() }}</div>
        </div>

        @if (($item->type ?? null) === 'spot')
            @php
                $categoryLabels = ['working' => 'Working', 'hospital' => 'Hospital', 'tourist' => 'Tourism'];
                $statusMap = [
                    // 'published' => ['label' => 'Published', 'class' => 'badge-status-published'],
                    'draft' => ['label' => 'Draft', 'class' => 'badge-status-draft'],
                    'unpublished' => ['label' => 'Unpublished', 'class' => 'badge-status-unpublished'],
                ];
                $statusInfo = $statusMap[$item->status] ?? null;
            @endphp
            <div class="hp-post-badges">
                <span
                    class="badge badge-{{ $item->category }}">{{ $categoryLabels[$item->category] ?? $item->category }}</span>
                @if ($statusInfo)
                    <span class="badge {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                @endif
            </div>
        @endif
    </div>

    <a href="{{ $item->url ?? '#' }}" class="text-decoration-none text-reset">
        <div class="hp-post-image-wrap">
            @if (!empty($item->image_url))
                <img src="{{ $item->image_url }}" class="hp-post-image" alt="{{ $item->title }}">
            @else
                <div class="hp-post-noimage">
                    <i class="fa-regular fa-image"></i>
                    <span>No Photo</span>
                </div>
            @endif
        </div>

        <div class="hp-post-body">
            <h6 class="hp-post-title">{{ $item->title }}</h6>
            <p class="hp-post-description">{{ $item->description }}</p>

            @if (($item->type ?? null) === 'spot' && $item->rating_avg)
                <p class="hp-post-rating">
                    <i class="fa-solid fa-star"></i>
                    {{ number_format($item->rating_avg, 1) }}（{{ $item->reviews_count }}件）
                </p>
            @endif
        </div>
    </a>

    <div class="hp-post-footer">
        <a href="{{ $item->url ?? '#' }}" class="hp-comment-link">Details</a>
    </div>
</div>

<style>
    .hp-post-badges {
        margin-left: auto;
        display: flex;
        gap: 6px;
    }

    .badge {
        font-size: 12px;
        padding: 2px 8px;
        border-radius: 6px;
    }

    .badge-working {
        background: #e1f5ee;
        color: #085041;
    }

    .badge-hospital {
        background: #faece7;
        color: #712b13;
    }

    .badge-tourist {
        background: #fbeaf0;
        color: #72243e;
    }

    .badge-status-published {
        background: #eaf3de;
        color: #27500a;
    }

    .badge-status-draft {
        background: #f1efe8;
        color: #444441;
    }

    .badge-status-unpublished {
        background: #fcebeb;
        color: #791f1f;
    }

    .hp-post-rating {
        font-size: 13px;
        color: #ba7517;
        margin: 4px 0 0;
    }

    .hp-post-noimage {
        width: 100%;
        height: 100%;
        min-height: 160px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background-color: #eef2f5;
        color: #8a94a6;
        font-size: 14px;
        font-weight: 500;
    }

    .hp-post-noimage i {
        font-size: 22px;
    }
</style>