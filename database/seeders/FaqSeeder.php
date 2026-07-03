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
                'question_en' => 'I do not know which hospital to visit.',
                'answer' => 'ページ上部の病院を探すボタンをプッシュしてください',
                'answer_en' => 'Please use the "Find a hospital" button at the top of the page.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'faq_category_id' => 2,
                'question' => 'キャッシュレス受診は可能ですか？',
                'question_en' => 'Is cashless treatment available?',
                'answer' => '海外旅行保険に加入している場合は一般的に可能です。ただし、病院と保険会社によって異なります。',
                'answer_en' => 'It is generally available if you have travel insurance, but it depends on the hospital and insurer.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'faq_category_id' => 2,
                'question' => 'キャッシュレス受診を希望する場合どうすればいいですか？',
                'question_en' => 'What should I do if I want cashless treatment?',
                'answer' => 'まずはJHDの公式ホームページまたは公式LINEより、直接お問い合わせください。JHD側のスタッフが病院および保険会社へ連絡し、キャッシュレス受診が可能か確認してもらうことが可能です。',
                'answer_en' => 'Contact JHD directly via their official website or LINE. JHD staff can check with the hospital and insurer whether cashless treatment is available.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'faq_category_id' => 3,
                'question' => 'JHDサポートとはどのようなサービスですか？',
                'question_en' => 'What is JHD support?',
                'answer' => 'キャッシュレス受診や日本語通訳、お薬の受け取り手順など、受診に関わる一連のサポートを日本人スタッフが行うサービスです。',
                'answer_en' => 'Japanese staff support you through cashless visits, interpretation, medication pickup, and other steps related to medical care.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'faq_category_id' => 3,
                'question' => '日本語対応の病院はありますか？',
                'question_en' => 'Are there Japanese-friendly hospitals?',
                'answer' => '病院カードのJHD対応タグをご確認ください',
                'answer_en' => 'Please check the JHD support tags on the hospital cards.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'faq_category_id' => 3,
                'question' => '保険に加入していなくてもJHDを利用できますか？',
                'question_en' => 'Can I use JHD without insurance?',
                'answer' => 'ご利用可能です。保険未加入の場合、実費として診察費用2,500ペソ、サポート費用2,500ペソの計5,000ペソが必要となります。',
                'answer_en' => 'Yes. Without insurance, you pay 2,500 PHP for the consultation and 2,500 PHP for support (5,000 PHP total).',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'faq_category_id' => 4,
                'question' => '英語で症状を伝えたい',
                'question_en' => 'I want to describe my symptoms in English',
                'answer' => "1. I have a fever\n2. I have a cough\n3. I have a headache\n4. I have stomach pain\n5. I feel chills\n6. I feel unusually dark or faint\n7. I have a rash\n8. I feel nauseous",
                'answer_en' => "1. I have a fever\n2. I have a cough\n3. I have a headache\n4. I have stomach pain\n5. I feel chills\n6. I feel unusually dark or faint\n7. I have a rash\n8. I feel nauseous",
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
