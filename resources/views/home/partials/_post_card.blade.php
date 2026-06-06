<div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
    {{-- ユーザー情報部分 --}}
    <div class="card-header bg-white border-0 d-flex align-items-center pt-3 pb-0">
        <img src="https://ui-avatars.com/api/?name={{ $item->user->name ?? 'User' }}" 
             class="rounded-circle me-2" width="35" height="35" alt="avatar">
        <div>
            <div class="fw-bold small">{{ $item->user->name ?? '匿名' }}</div>
            <div class="text-muted" style="font-size: 0.7rem;">{{ $item->created_at->diffForHumans() }}</div>
        </div>
    </div>

    {{-- 投稿画像 --}}
    <img src="https://placehold.co/400x250" class="card-img-top p-2" style="border-radius: 20px;" alt="post image">

    {{-- 本文 --}}
    <div class="card-body pt-0">
        <h6 class="card-title fw-bold mb-1">{{ $item->title }}</h6>
        <p class="card-text small text-muted mb-2">
            {{ $item->description }}
        </p>
        <div class="text-info small mb-2">#セブライフ #Kredon</div>
    </div>

    {{-- アクションボタン --}}
    <div class="card-footer bg-white border-0 d-flex justify-content-between pb-3">
        <span><i class="bi bi-chat"></i> 12</span>
        <span><i class="bi bi-bookmark"></i></span>
    </div>
</div>