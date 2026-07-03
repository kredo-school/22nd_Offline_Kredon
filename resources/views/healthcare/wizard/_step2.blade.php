@include('healthcare.wizard._wizard_card', [
    'step' => 2,
    'question' => __('healthcare.wizard.step2.question'),
    'options' => [
        'yes' => __('healthcare.wizard.step2.yes'),
        'no' => __('healthcare.wizard.step2.no'),
    ],
])
