<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'faq_category_id' => 1,
                'question' => 'どの病院へ行って良いかわからない',
                'answer' => '病院検索ボタンをプッシュしてください',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'faq_category_id' => 2,
                'question' => 'キャッシュレス受診は可能ですか？',
                'answer' => '病院と保険会社によって異なります',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'faq_category_id' => 2,
                'question' => 'キャシュレス受診を希望する場合どうすればいいですか？',
                'answer' => 'まずはJHDの公式ホームページまたは公式LINEより、直接お問い合わせください。JHD側のスタッフが病院および保険会社へ連絡し、キャッシュレス受診が可能か確認してもらうことが可能です。',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'faq_category_id' => 3,
                'question' => ' JHDサポートとはどのようなサービスですか？',
                'answer' => 'キャッシュレス受診や日本語通訳、お薬の受け取り手順など、受診に関わる一連のサポートを日本人スタッフが行うサービスです。',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'faq_category_id' => 3,
                'question' => '日本語対応の病院はありますか？',
                'answer' => '病院カードの日本語対応タグをご確認ください',
                'is_active' => true,
                'sort_order' => 2,

            ],
            [
                'faq_category_id' => 3,
                'question' => '保険に加入していなくてもJHDを利用できますか？',
                'answer' => 'ご利用可能です。保険未加入の場合、実費として診察費用2,500ペソ、サポート費用2,500ペソの計5,000ペソが必要となります。',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'faq_category_id' => 4,
                'question' =>'英語で症状を伝えたい',
                'answer' => 
               '1.熱がある 
                2.咳が出る 
                3.頭が痛い 
                4.お腹が痛い
                5.寒気がする
                6.
                7.発疹がでている
                8.吐き気がする',
                'is_active' => true,
                'sort_order' => 1,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
