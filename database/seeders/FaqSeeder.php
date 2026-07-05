<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $categories = FaqCategory::pluck('id', 'slug');

        if (isset($categories['emergency'])) {
            Faq::query()
                ->where('faq_category_id', $categories['emergency'])
                ->where('question', '緊急時に英語で伝えたい')
                ->delete();
        }

        $faqs = [
            [
                'category_slug' => 'emergency',
                'question' => '緊急時に使えるフレーズが知りたい',
                'question_en' => 'Phrases for emergency situations',
                'answer' => "【現在地・状態】\n1.ITパークのSkyrise 4にる ⇔ I am at IT Park, Skyrise4. \n2.救急車を呼びたい ⇔ Please send an ambulance. \n3. 意識が朦朧とする ⇔ I feel drowsy. \n4. 足を骨折したかもしれない ⇔ I might have broken my leg. \n5. 大量に出血しており、今すぐ助けが必要 ⇔ There is heavy bleeding. I need help immediately. \n6. 呼吸ができない ⇔ I cannot breathe. \n7. 意識がない ⇔ I am unconscious. \n8. 体の一部が動かせない ⇔ I cannot move part of my body.",
                'answer_en' => "【Location & Condition】\n1. I am at IT Park, Skyrise 4\n\n【Emergency Phrases】\n2. I am bleeding heavily.\n3. The bleeding won't stop.\n4. Please send an ambulance.",
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'fever-cold',
                'question' => '英語で症状を伝えたい',
                'question_en' => 'I want to describe my symptoms in English',
                'answer' => "熱がある ⇔ I have a fever\n 咳が出る ⇔ I have a cough\n 頭痛がある ⇔ I have a headache\n 腹痛がある ⇔ I have stomach pain\n 寒気がする ⇔ I feel chills\n ぼんやりする ⇔ I feel unusually dark or faint\n 発疹がある ⇔ I have a rash\n 悪心がある ⇔ I feel nauseous",
                'answer_en' => "I have a fever\n I have a cough\n I have a headache\n I have stomach pain\n I feel chills\n I feel unusually dark or faint\n I have a rash\n I feel nauseous",
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'fever-cold',
                'question' => 'どの病院へ行って良いかわからない',
                'question_en' => 'I do not know which hospital to visit.',
                'answer' => 'まずはQQEnglish6階の医務室にご相談ください',
                'answer_en' => 'Please consult the medical office on the 6th floor of QQEnglish first.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'insurance',
                'question' => 'キャッシュレス受診は可能ですか？',
                'question_en' => 'Is cashless treatment available?',
                'answer' => '海外旅行保険に加入している場合は一般的に可能です。ただし、病院と保険会社によって異なります。',
                'answer_en' => 'It is generally available if you have travel insurance, but it depends on the hospital and insurer.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'insurance',
                'question' => 'キャッシュレス受診を希望する場合どうすればいいですか？',
                'question_en' => 'What should I do if I want cashless treatment?',
                'answer' => 'まずはJHDの公式ホームページまたは公式LINEより、直接お問い合わせください。JHD側のスタッフが病院および保険会社へ連絡し、キャッシュレス受診が可能か確認してもらうことが可能です。',
                'answer_en' => 'Contact JHD directly via their official website or LINE. JHD staff can check with the hospital and insurer whether cashless treatment is available.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'jhd',
                'question' => 'JHDサポートとはどのようなサービスですか？',
                'question_en' => 'What is JHD support?',
                'answer' => 'キャッシュレス受診や日本語通訳、お薬の受け取り手順など、受診に関わる一連のサポートを日本人スタッフが行うサービスです。',
                'answer_en' => 'Japanese staff support you through cashless visits, interpretation, medication pickup, and other steps related to medical care.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'jhd',
                'question' => '日本語対応の病院はありますか？',
                'question_en' => 'Are there Japanese-friendly hospitals?',
                'answer' => '病院カードのJHD対応タグをご確認ください',
                'answer_en' => 'Please check the JHD support tags on the hospital cards.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'jhd',
                'question' => '保険に加入していなくてもJHDを利用できますか？',
                'question_en' => 'Can I use JHD without insurance?',
                'answer' => 'ご利用可能です。保険未加入の場合、実費として診察費用2,500ペソ、サポート費用2,500ペソの計5,000ペソが必要となります。',
                'answer_en' => 'Yes. Without insurance, you pay 2,500 PHP for the consultation and 2,500 PHP for support (5,000 PHP total).',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($faqs as $faq) {
            $slug = $faq['category_slug'];
            unset($faq['category_slug']);

            if (! isset($categories[$slug])) {
                continue;
            }

            $faq['faq_category_id'] = $categories[$slug];

            Faq::updateOrCreate(
                [
                    'faq_category_id' => $faq['faq_category_id'],
                    'sort_order' => $faq['sort_order'],
                ],
                $faq
            );
        }
    }
}
