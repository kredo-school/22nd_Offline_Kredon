<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spot;
use App\Models\Review;
use App\Models\User;

class SpotSeeder extends Seeder
{
    public function run(): void
    {
        // 💡 テスト用のユーザーを一瞬で作る（レビューを書いた人にするため）
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'クレどん先輩', 'password' => bcrypt('password')]
        );

        // 1. ITパークカフェのデータ作成
        $spot1 = Spot::create([
            'name' => 'ITパークカフェ',
            'area' => 'it-park',
            'hours' => '9:00 - 18:00',
            'has_wifi' => true,
            'has_power' => true,
        ]);

        // 💡 ITパークカフェに「死角度★5」のガチな口コミを紐づける！
        Review::create([
            'spot_id' => $spot1->id,
            'user_id' => $user->id,
            'dead_spot_rating' => 5, // ← 死角度★5！
            'aircon_level' => 4,      // ← 結構寒い★4
            'stay_time_level' => 5,   // ← 長居できる★5
            'comment' => '奥の角席が店員の死角になっていて超集中できます。エアコン強いので上着必須！',
        ]);

        // 2. アヤラ・コワーキングのデータ作成
        $spot2 = Spot::create([
            'name' => 'アヤラ・コワーキング',
            'area' => 'ayala',
            'hours' => '9:00 - 18:00',
            'has_wifi' => true,
            'has_power' => true,
        ]);

        // 💡 アヤラ・コワーキングに別の口コミを紐づける！
        Review::create([
            'spot_id' => $spot2->id,
            'user_id' => $user->id,
            'dead_spot_rating' => 3,
            'aircon_level' => 2,
            'stay_time_level' => 4,
            'comment' => '綺麗で開放的だけど、中央の席は少し周りの視線が気になるかも。',
        ]);
    }
}