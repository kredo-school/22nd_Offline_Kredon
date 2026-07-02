<?php

namespace Database\Seeders;

use App\Models\NgWord;
use Illuminate\Database\Seeder;

class NgWordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            ['word' => 'kill yourself', 'category' => 'harassment', 'min_strength' => 'high'],
            ['word' => 'stupid', 'category' => 'harassment', 'min_strength' => 'standard'],
            ['word' => 'idiot', 'category' => 'harassment', 'min_strength' => 'standard'],
            ['word' => '死ね', 'category' => 'harassment', 'min_strength' => 'high'],
            ['word' => 'バカ', 'category' => 'harassment', 'min_strength' => 'low'],
            ['word' => 'line.me', 'category' => 'spam', 'min_strength' => 'standard'],
            ['word' => 'add me on line', 'category' => 'spam', 'min_strength' => 'standard'],
            ['word' => 'click here', 'category' => 'spam', 'min_strength' => 'low'],
            ['word' => 'ライン交換', 'category' => 'spam', 'min_strength' => 'standard'],
        ];

        foreach ($words as $row) {
            NgWord::query()->updateOrCreate(
                ['word' => $row['word'], 'category' => $row['category']],
                ['min_strength' => $row['min_strength'], 'is_active' => true]
            );
        }
    }
}
