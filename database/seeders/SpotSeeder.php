<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spot; // ▼ここを追加（Spotモデルを使うための宣言）

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ▼ここから追加（テストデータを2つ登録します）
        Spot::create([
            'name' => 'ITパークカフェ',
            'area' => 'it-park',
            'hours' => '9:00 - 18:00',
            'has_wifi' => true,
            'has_power' => true,
            'map_url' => 'https://maps.google.com/...',
        ]);

        Spot::create([
            'name' => 'アヤラ・コワーキング',
            'area' => 'ayala',
            'hours' => '9:00 - 18:00',
            'has_wifi' => true,
            'has_power' => true,
            'map_url' => 'https://maps.google.com/...',
        ]);
        // ▲ここまで追加
    }
}