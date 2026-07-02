<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'title'       => 'Kredonがプロテインを出品しました',
                'body'        => 'wheyのプロテインがマーケットに出品されました。',
                'category'    => 'item_alert',
                'target_type' => 'all',
                'url'         => '/market',
                'sent_at'     => now()->subHours(2),
            ],
            [
                'title'       => '卒業間近の生徒様へ',
                'body'        => '有料会員の解除をお忘れなく。',
                'category'    => 'system',
                'target_type' => 'all',
                'url'         => '/settings/account',
                'sent_at'     => now()->subDay(),
            ],
            [
                'title'       => 'IT Park 勉強会のお知らせ',
                'body'        => '今週土曜 14:00 よりコワーキングスペースで勉強会を開催します。',
                'category'    => 'event',
                'target_type' => 'all',
                'url'         => '/event',
                'sent_at'     => now()->subDays(2),
            ],
            [
                'title'       => 'プレミアム会員限定イベント',
                'body'        => '来週のスポットツアーにご招待。詳細はイベントページをご確認ください。',
                'category'    => 'digest',
                'target_type' => 'subscriber',
                'url'         => '/event',
                'sent_at'     => now()->subDays(3),
            ],
            [
                'title'       => '新着スポットレビュー',
                'body'        => 'ITパークカフェに新しい口コミが投稿されました。',
                'category'    => 'comment',
                'target_type' => 'all',
                'url'         => '/review',
                'sent_at'     => now()->subDays(4),
            ],
        ];

        foreach ($announcements as $item) {
            Notification::query()->firstOrCreate(
                ['title' => $item['title']],
                [
                    'template_id'  => null,
                    'recipient_id' => null,
                    'target_type'  => $item['target_type'],
                    'category'     => $item['category'],
                    'body'         => $item['body'],
                    'data'         => [
                        'url'       => $item['url'],
                        'link_url'  => $item['url'],
                        'send_push' => true,
                        'send_email' => false,
                        'user_ids'  => [],
                    ],
                    'is_read'      => false,
                    'scheduled_at' => null,
                    'sent_at'      => $item['sent_at'],
                    'status'       => 'sent',
                ]
            );
        }
    }
}
