<?php

namespace App\Listeners;

use App\Events\ItemPublished;
use App\Models\Notification;
use App\Models\NotificationTemplate;
use App\Models\NotificationSubscription;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCategoryNotification implements ShouldQueue
{
    use InteractsWithQueue;

    private const NOTIFY_ON = 'new_item';

    public function handle(ItemPublished $event): void
    {
        $itemPost = $event->itemPost;
        $category = $itemPost->category; // ただの文字列（例: "Tourism"）

        if (!$category) {
            return;
        }

        // このカテゴリー文字列を購読しているユーザーがいるか確認
        $hasSubscribers = NotificationSubscription::where('category', $category)
            ->where('notify_on', self::NOTIFY_ON)
            ->where('is_active', true)
            ->exists();

        if (!$hasSubscribers) {
            return;
        }

        $template = NotificationTemplate::where('category', 'item_alert')
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$template) {
            return;
        }

        $replacements = [
            '{{category_name}}' => $category,
            '{{item_name}}'     => $itemPost->title, // ItemPostはnameでなくtitleカラム
        ];

        Notification::create([
            'template_id'  => $template->id,
            'recipient_id' => null,
            'target_type'  => 'subscriber',
            'category'     => 'item_alert',
            'title'        => strtr($template->title, $replacements),
            'body'         => strtr($template->body, $replacements),
            'data'         => [
                'item_post_id' => $itemPost->id,
                'category'     => $category,
                'notify_on'    => self::NOTIFY_ON,
            ],
            'status'  => 'sent',
            'sent_at' => now(),
        ]);
    }
}