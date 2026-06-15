<div class="kk-post-card">
    {{-- ユーザー情報部分 --}}
    <div class="kk-post-header">
        <img src="https://ui-avatars.com/api/?name={{ $item->user->name ?? 'User' }}" 
             class="kk-avatar" alt="avatar">
        <div>
            <div class="kk-user-name">{{ $item->user->name ?? '匿名' }}</div>
            <div class="kk-post-date">{{ $item->created_at->diffForHumans() }}</div>
        </div>
    </div>

    {{-- 投稿画像 --}}
    <div class="kk-post-image-wrap">
        <img src="https://placehold.co/400x250" class="kk-post-image" alt="post image">
    </div>

    {{-- 本文 --}}
    <div class="kk-post-body">
        <h6 class="kk-post-title">{{ $item->title }}</h6>
        <p class="kk-post-description">
            {{ $item->description }}
        </p>
        <div class="kk-post-tags">#セブライフ #Kredon</div>
    </div>

    {{-- アクションボタン --}}
    <div class="kk-post-footer">
        <span><i class="fa-regular fa-comment"></i> 12</span>
        <span><i class="fa-regular fa-bookmark"></i></span>
    </div>
</div>