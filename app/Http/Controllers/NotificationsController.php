<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\NotifSubscriptoin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    // 💡 解決策: 定数の定義をクラスの最上部に移動（これでエディタが完全に見つけられます）
    private const CATEGORY_LABELS = [
        'system'     => 'System',
        'reply'      => 'Reply',
        'comment'    => 'Comment',
        'like'       => 'Like',
        'event'      => 'Event',
        'item_alert' => 'Item Alert',
        'digest'     => 'Digest',
    ];

    private const CATEGORY_ICONS = [
        'system'     => 'fa-solid fa-gear',
        'reply'      => 'fa-solid fa-reply',
        'comment'    => 'fa-regular fa-comment',
        'like'       => 'fa-regular fa-heart',
        'event'      => 'fa-solid fa-calendar-days',
        'item_alert' => 'fa-solid fa-bell',
        'digest'     => 'fa-solid fa-layer-group',
    ];

    /**
     * navbarのベルModal用
     */
    public static function listForUser(int $userId): array
    {
        $user = User::find($userId);
        $isSubscriber = $user && (int) $user->role === 3;

        $notifications = Notification::where('status', 'sent')
            ->where(function ($q) use ($isSubscriber, $userId) {
                $q->where('target_type', 'all');

                if ($isSubscriber) {
                    $q->orWhere('target_type', 'subscriber');
                }

                $q->orWhere(function ($sub) use ($userId) {
                    $sub->where('target_type', 'custom')
                        ->whereJsonContains('data->user_ids', $userId);
                });
            })
            ->orderByDesc('sent_at')
            ->get();

        $readIds = NotificationRead::where('user_id', $userId)
            ->pluck('notification_id')
            ->flip()
            ->toArray();

        $list = [];

        foreach ($notifications as $notif) {
            $list[] = [
                'id'       => $notif->id,
                'category' => $notif->category ?? 'system',
                'title'    => $notif->title,
                'body'     => $notif->body,
                'url'      => method_exists($notif, 'getUrl') ? $notif->getUrl() : '#',
                'is_read'  => isset($readIds[$notif->id]),
                'time'     => $notif->sent_at ? $notif->sent_at->diffForHumans() : null,
            ];
        }

        return $list;
    }

    public static function unreadCountForUser(int $userId): int
    {
        $list = static::listForUser($userId);

        return count(array_filter($list, fn ($item) => !$item['is_read']));
    }

    public static function categoryLabels(): array
    {
        return static::CATEGORY_LABELS;
    }

    public static function categoryIcons(): array
    {
        return static::CATEGORY_ICONS;
    }

    /**
     * 通知モーダルを開いたタイミングで一括既読化
     */
    public function markAllRead(Request $request)
    {
        $userId = Auth::id();

        $list = static::listForUser($userId);

        foreach ($list as $item) {
            if (!$item['is_read']) {
                NotificationRead::firstOrCreate(
                    ['notification_id' => $item['id'], 'user_id' => $userId],
                    ['read_at' => now()]
                );
            }
        }

        return response()->json(['success' => true]);
    }
}