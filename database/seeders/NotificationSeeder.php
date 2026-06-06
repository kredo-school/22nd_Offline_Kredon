<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Notification::create ([
            'user_id' => 1,
            'title'   => 'Miyumu君がプロテインを出品しました',
            'message' => 'wheyのプロテイン',
            'is_read' => 0,
            'type'    => 'item_posted',
        ]);

        Notification::create ([
            'user_id' => 1,
            'title'   => '卒業間近の生徒様へ',
            'message' => '有料会員会員の解除をお忘れなく',
            'is_read' => 0,
            'type'    => 'account_alert',
        ]);

        for ($i = 1; $i <= 10; $i++) {
            Notification::create ([
            'user_id' => 1,
            'title'   => '出品者からの通知',
            'message' => '譲渡します',
            'is_read' => 0,
            'type'    => 'item_posted',
            ]);
        }
    }
}
