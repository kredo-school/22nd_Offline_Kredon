<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterTempSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'name'        => 'クレドン',
                'slug'        => 'kuredon',
                'image_path'  => '/images/characters/kuredon.png',
                'initial'     => 'ク',
                'bg_color'    => '#2A87C8',
                'accent'      => 'blue',
                'description' => 'セブ島ITパークの公式マスコット。元気でフレンドリー。',
                'is_default'  => true,
                'is_active'   => true,
            ],
            [
                'name'        => 'クレジナ',
                'slug'        => 'kurejina',
                'image_path'  => '/images/characters/kurejina.png',
                'initial'     => 'ジ',
                'bg_color'    => '#6BBD99',
                'accent'      => 'teal',
                'description' => 'マーケットやイベント情報が得意なキャラクター。',
                'is_default'  => false,
                'is_active'   => true,
            ],
            [
                'name'        => 'クレミチ',
                'slug'        => 'kuremichi',
                'image_path'  => '/images/characters/kuremichi.png',
                'initial'     => 'ミ',
                'bg_color'    => '#7B61FF',
                'accent'      => 'purple',
                'description' => '勉強スポットや留学生活の相談に乗ってくれるキャラクター。',
                'is_default'  => false,
                'is_active'   => true,
            ],
        ];

        foreach ($rows as $row) {
            DB::table('character_temps')->updateOrInsert(
                ['slug' => $row['slug']],
                array_merge($row, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}
