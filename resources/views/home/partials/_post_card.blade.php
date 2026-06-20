<div class="hp-post-card">
    {{-- ユーザー情報部分 --}}
    <div class="hp-post-header">
        <img src="https://ui-avatars.com/api/?name={{ $item->user->name ?? 'User' }}" 
             class="hp-avatar" alt="avatar">
        <div>
            <div class="hp-user-name">{{ $item->user->name ?? '匿名' }}</div>
            <div class="hp-post-date">{{ $item->created_at->diffForHumans() }}</div>
        </div>
    </div>

    {{-- 投稿画像 --}}
    <div class="hp-post-image-wrap">
        <img src="https://placehold.co/400x250" class="hp-post-image" alt="post image">
    </div>

    {{-- 本文 --}}
    <div class="hp-post-body">
        <h6 class="hp-post-title">{{ $item->title }}</h6>
        <p class="hp-post-description">
            {{ $item->description }}
        </p>
        <div class="hp-post-tags">#セブライフ #Kredon</div>
    </div>

    {{-- アクションボタン --}}
    <div class="hp-post-footer">
        <a href="#" class="hp-comment-link"></a>
        <span><i class="fa-regular fa-bookmark"></i></span>
    </div>
</div>