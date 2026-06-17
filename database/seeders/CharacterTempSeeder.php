<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterTempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('character_temps')->insert([
            [
                'name'       => 'クレドン',
                'image_path' => '/images/characters/kuredon.png',
                'slug'       => 'kuredon',
                'is_default' => true,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name'       => 'クレジナ',
                'image_path' => '/images/characters/kuredon.png',
                'slug'       => 'kurejina',
                'is_default' => false,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'クレミチ',
                'image_path' => '/images/characters/kuredon.png',
                'slug'       => 'kuremichi',
                'is_default' => false,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
