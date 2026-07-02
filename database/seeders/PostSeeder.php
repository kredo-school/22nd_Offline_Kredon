<?php

namespace Database\Seeders;

use App\Models\ItemPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('email', 'kredon.cebu@gmail.com')->first()
            ?? User::query()->first();

        if (! $user) {
            return;
        }

        $posts = [
            [
                'title'         => 'プロテインを譲渡します',
                'location_name' => 'IT Park',
                'description'   => '未開封のホエイプロテインです。',
                'category'      => 'food',
                'status'        => 'active',
            ],
            [
                'title'         => 'マグカップ譲ります',
                'location_name' => 'Ayala',
                'description'   => '7月30日に帰国するのでほしい方はぜひそれまでに',
                'category'      => 'daily',
                'status'        => 'active',
            ],
            [
                'title'         => 'QQの教科書譲ります',
                'location_name' => 'IT Park',
                'description'   => 'カランの教科書１冊',
                'category'      => 'study',
                'status'        => 'active',
            ],
            [
                'title'         => 'デスクライト譲渡',
                'location_name' => 'IT Park',
                'description'   => 'LEDライト。明るさ調整可能です。',
                'category'      => 'daily',
                'status'        => 'active',
            ],
            [
                'title'         => 'フィリピン語の参考書',
                'location_name' => 'Cebu City',
                'description'   => '初心者向けテキスト。書き込みなし。',
                'category'      => 'study',
                'status'        => 'active',
            ],
        ];

        foreach ($posts as $data) {
            ItemPost::query()->firstOrCreate(
                ['user_id' => $user->id, 'title' => $data['title']],
                $data
            );
        }
    }
}
