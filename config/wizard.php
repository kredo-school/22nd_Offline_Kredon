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

    'version' => '7',

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
            'subtitle' => 'healthcare.wizard.step1.subtitle',
            'options' => [
                'mild' => [
                    'label' => 'healthcare.wizard.step1.mild',
                    'subtitle' => 'healthcare.wizard.step1.mild_sub',
                ],
                'severe' => [
                    'label' => 'healthcare.wizard.step1.severe',
                    'subtitle' => 'healthcare.wizard.step1.severe_sub',
                ],
                'ent' => [
                    'label' => 'healthcare.wizard.step1.ent',
                    'subtitle' => 'healthcare.wizard.step1.ent_sub',
                ],
                'skin' => [
                    'label' => 'healthcare.wizard.step1.skin',
                    'subtitle' => 'healthcare.wizard.step1.skin_sub',
                ],
            ],
        ],
        2 => [
            'question' => 'healthcare.wizard.step2.question',
            'subtitle' => 'healthcare.wizard.step2.subtitle',
            'options' => [
                'yes' => [
                    'label' => 'healthcare.wizard.step2.yes',
                ],
                'no' => [
                    'label' => 'healthcare.wizard.step2.no',
                    'subtitle' => 'healthcare.wizard.step2.no_sub',
                ],
            ],
        ],
        3 => [
            'question' => 'healthcare.wizard.step3.question',
            'subtitle' => 'healthcare.wizard.step3.subtitle',
            'options' => [
                'yes' => [
                    'label' => 'healthcare.wizard.step3.yes',
                    'subtitle' => 'healthcare.wizard.step3.yes_sub',
                ],
                'no' => [
                    'label' => 'healthcare.wizard.step3.no',
                    'subtitle' => 'healthcare.wizard.step3.no_sub',
                ],
            ],
            'info_options' => [
                'unknown' => [
                    'label' => 'healthcare.wizard.step3.unknown',
                    'hint' => 'healthcare.wizard.step3.unknown_hint',
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
        1 => ['mild', 'ent', 'skin'],
    ],

];
