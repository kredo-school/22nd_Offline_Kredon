{{-- ══════════════════════════════════
     ユーザー向け通知 Modal
     Admin側と同じ見た目: カテゴリピルバッジ付きカード、新着順1列
══════════════════════════════════ --}}
<div class="modal fade" id="userNotificationsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden;">

            <div class="modal-header border-0 pb-2">
                <h5 class="modal-title d-flex align-items-center gap-2 fw-bold">
                    <i class="fa-solid fa-bell" style="color: darkcyan;"></i> Notifications
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body pt-0" style="max-height: 70vh; overflow-y: auto;">

                @forelse ($notifications as $notif)
                    <a href="{{ $notif['url'] ?? '#' }}"
                        class="notif-card {{ $notif['is_read'] ? '' : 'unread' }}">
                        
                        <div class="d-flex gap-1">
                            <span class="notif-pill notif-pill-{{ $notif['category'] }}">
                                <i class="{{ $categoryIcons[$notif['category']] ?? 'fa-solid fa-circle-info' }}"></i>
                                {{ $categoryLabels[$notif['category']] ?? ucfirst($notif['category']) }}
                            </span>

                            <div class="notif-card-title">{{ $notif['title'] }}</div>
                        </div>
                        <div class="notif-card-body">{{ $notif['body'] }}</div>
                        <div class="notif-card-meta">{{ $notif['time'] }}</div>
                    </a>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="fa-regular fa-bell-slash fa-2x mb-2"></i>
                        <p class="mb-0">No notifications yet</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</div>

<style>
    .notif-card {
        display: block;
        padding: 14px 6px;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #cfdae5;
        transition: background 0.15s;
    }

    .notif-card:last-child {
        border-bottom: none;
    }

    .notif-card:hover {
        background-color: #f8f9fa;
        color: inherit;
    }

    .notif-card.unread {
        background-color: rgba(0, 139, 139, 0.05);
    }

    .notif-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 999px;
        margin-bottom: 8px;
    }

    .notif-pill i {
        font-size: 0.68rem;
    }

    .notif-pill-system {
        background-color: #e7f1ff;
        color: #2b6cd4;
    }

    .notif-pill-reply {
        background-color: #e6f7ee;
        color: #1e9e5a;
    }

    .notif-pill-comment {
        background-color: #e6f7ee;
        color: #1e9e5a;
    }

    .notif-pill-like {
        background-color: #fde8ef;
        color: #d6336c;
    }

    .notif-pill-event {
        background-color: #fff4e0;
        color: #b3791e;
    }

    .notif-pill-item_alert {
        background-color: #f1eaff;
        color: #6f42c1;
    }

    .notif-pill-digest {
        background-color: #eceff1;
        color: #546e7a;
    }

    .notif-card-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #212529;
    }

    .notif-card.unread .notif-card-title::after {
        content: '';
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: darkcyan;
        margin-left: 8px;
        vertical-align: middle;
    }

    .notif-card-body {
        font-size: 0.85rem;
        color: #3d454d;
        margin-top: 2px;
    }

    .notif-card-meta {
        font-size: 0.75rem;
        color: #adb5bd;
        margin-top: 6px;
    }

    .badge-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 8px;
        height: 8px;
        background-color: #dc3545;
        border-radius: 50%;
        border: 1.5px solid #fff;
    }
</style>