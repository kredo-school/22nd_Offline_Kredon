<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqCategoryTest; 

class FaqCategoyTestSeeder extends Seeder
{
    public function run(): void
    {
        // データを配列のリストとして定義
        $categories = [
            [
                'name'       => '発熱・風邪',
                'slug'       => 'fever-cold', // ここにスラッグを入力
                'icon_class' => 'fa-solid fa-temperature-high'
            ],
            [
                'name'       => '保険・支払い',
                'slug'       => 'insurance',
                'icon_class' => 'fa-solid fa-file-medical'
            ],
            [
                'name'       => 'JHDサポート',
                'slug'       => 'jhd',
                'icon_class' => 'fa-solid fa-headset',
            ],
        ];

        // データベースに挿入
        foreach ($categories as $category) {
        FaqCategoryTest::updateOrCreate(
            ['slug' => $category['slug']], 
            $category 
        );                     
      }
    }
}