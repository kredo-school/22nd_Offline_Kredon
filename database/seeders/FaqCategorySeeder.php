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
                'name' => '緊急',
                'name_en' => 'Emergency',
                'slug' => 'emergency',
                'icon_class' => 'fa-solid fa-truck-medical',
                'sort_order' => 1,
            ],
            [
                'name' => '発熱・風邪',
                'name_en' => 'Fever & cold',
                'slug' => 'fever-cold',
                'icon_class' => 'fa-solid fa-temperature-high',
                'sort_order' => 2,
            ],
            [
                'name' => '保険・支払い',
                'name_en' => 'Insurance & payment',
                'slug' => 'insurance',
                'icon_class' => 'fa-solid fa-file-medical',
                'sort_order' => 3,
            ],
            [
                'name' => 'JHDサポート',
                'name_en' => 'JHD support',
                'slug' => 'jhd',
                'icon_class' => 'fa-solid fa-headset',
                'sort_order' => 4,
            ],
            [
                'name' => 'その他',
                'name_en' => 'Other',
                'slug' => 'other',
                'icon_class' => 'fa-solid fa-comment-medical',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            FaqCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
