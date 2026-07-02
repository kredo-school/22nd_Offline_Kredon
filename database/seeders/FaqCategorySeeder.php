<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => '発熱・風邪',
                'slug' => 'fever-cold',
                'icon_class' => 'fa-solid fa-temperature-high',
                'sort_order' => 1,
            ],
            [
                'name' => '保険・支払い',
                'slug' => 'insurance',
                'icon_class' => 'fa-solid fa-file-medical',
                'sort_order' => 2,
            ],
            [
                'name' => 'JHDサポート',
                'slug' => 'jhd',
                'icon_class' => 'fa-solid fa-headset',
                'sort_order' => 3,
            ],
            [
                'name' => 'その他',
                'slug' => 'other',
                'icon_class' => 'fa-solid fa-comment-medical',
                'sort_order' => 4,
            ]
        ];

        foreach ($categories as $category) {
            FaqCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
