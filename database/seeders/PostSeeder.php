<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemPost;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemPost::create([
            'user_id' => 1,
            'title' => 'プロテインを譲渡します',
            'description' => '未開封のホエイプロテインです。',
            'status' => 'active',
        ]);

        ItemPost::create([
            'user_id' => 1,
            'title' => 'マグカップ譲ります',
            'description' => '7月30日に帰国するのでほしい方はぜひそれまでに',
            'status' => 'active',
        ]);

        ItemPost::create([
            'user_id' => 1,
            'title' => 'QQの教科書譲ります',
            'description' => 'カランの教科書１冊',
            'status' => 'active',
        ]);
    }
}
