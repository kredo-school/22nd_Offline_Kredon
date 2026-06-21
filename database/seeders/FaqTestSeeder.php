<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\FaqTest; 
use Illuminate\Database\Seeder;

class FaqTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'faq_category_id' => 1,
                'question'        => '熱が出た',
                'answer'          => '病院検索ウィザードをご利用ください',
            ],

            [
                'faq_category_id' => 2,
                'question'        => 'キャッシュレス受診できるか？',
                'answer'          => '病院と保険会社によって異なります',
            ],

            [
                'faq_category_id' => 3,
                'question'        => '日本語対応の病院はありますか？',
                'answer'          => '病院カードの日本語対応タグをご確認ください',
            ],      
        ];

        foreach ($faqs as $faq) {
            FaqTest::updateOrCreate(
                ['question' => $faq['question']], 
                $faq
            );
        }
    }
}
