<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
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
     * navbarのベルModal用：ログインユーザー宛ての通知を新着順フラットリストで返す
     * (View Composerから呼ばれることを想定。Admin側Modalと同じ見た目に合わせ、
     *  見出しグルーピングではなく各カードにカテゴリピルバッジを表示する形式)
     *
     * 対象となる通知:
     *  - target_type = all          : 全員宛て
     *  - target_type = subscriber   : role = 3 (premium member) のユーザーのみ
     *  - target_type = custom       : data.user_ids に自分のIDが含まれる場合のみ
     *
     * 既読判定は notification_reads テーブルに自分の行が存在するかどうかで判定する
     * (Notification.is_read / read_at は使わない、配信設定行は複数人で共有されるため)
     */
    public static function listForUser(int $userId): array
    {
        $user = \App\Models\User::find($userId);
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

        // このユーザーが既読済みの notification_id 一覧
        $readIds = NotificationRead::where('user_id', $userId)
            ->pluck('notification_id')
            ->flip(); // isset()チェックをO(1)にするため

        $list = [];

        foreach ($notifications as $notif) {
            $list[] = [
                'id'       => $notif->id,
                'category' => $notif->category ?? 'system',
                'title'    => $notif->title,
                'body'     => $notif->body,
                'url'      => $notif->getUrl(),
                'is_read'  => isset($readIds[$notif->id]),
                'time'     => optional($notif->sent_at)->diffForHumans(),
            ];
        }

        return $list;
    }

    public static function unreadCountForUser(int $userId): int
    {
        $list = self::listForUser($userId);

        return count(array_filter($list, fn ($item) => !$item['is_read']));
    }

    public static function categoryLabels(): array
    {
        return self::CATEGORY_LABELS;
    }

    public static function categoryIcons(): array
    {
        return self::CATEGORY_ICONS;
    }

    /**
     * 通知モーダルを開いたタイミングで一括既読化
     * (自分が対象の通知すべてに対して、notification_reads にレコードを作成)
     */
    public function markAllRead(Request $request)
    {
        $userId = Auth::id();

        $list = self::listForUser($userId);

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