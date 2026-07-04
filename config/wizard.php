<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Wizard version
    |--------------------------------------------------------------------------
    |
    | Increment when step definitions or flow change. Stale sessions are reset.
    |
    */

    'version' => '3',

    /*
    |--------------------------------------------------------------------------
    | Wizard steps
    |--------------------------------------------------------------------------
    |
    | Step order and option keys. Labels are resolved via lang files.
    |
    */

    'steps' => [
        1 => [
            'question' => 'healthcare.wizard.step1.question',
            'options' => [
                'mild' => 'healthcare.wizard.step1.mild',
                'severe' => 'healthcare.wizard.step1.severe',
            ],
        ],
        2 => [
            'question' => 'healthcare.wizard.step2.question',
            'options' => [
                'yes' => 'healthcare.wizard.step2.yes',
                'no' => 'healthcare.wizard.step2.no',
            ],
        ],
        3 => [
            'question' => 'healthcare.wizard.step3.question',
            'options' => [
                'yes' => 'healthcare.wizard.step3.yes',
                'no' => 'healthcare.wizard.step3.no',
            ],
            'info_options' => [
                'unknown' => [
                    'label' => 'healthcare.wizard.step3.unknown',
                    'faq_category_slug' => 'jhd',
                    'faq_sort_order' => 1,
                ],
                'no_insurance_jhd' => [
                    'label' => 'healthcare.wizard.step3.no_insurance_jhd',
                    'faq_category_slug' => 'jhd',
                    'faq_sort_order' => 3,
                    'show_when' => [
                        'step' => 2,
                        'answer' => 'no',
                    ],
                ],
            ],
        ],
    ],

    'early_complete' => [
        1 => ['mild'],
    ],

];
