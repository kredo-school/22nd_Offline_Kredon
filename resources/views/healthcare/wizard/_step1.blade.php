@include('healthcare.wizard._wizard_card', [
    'step' => 1,
    'question' => __('healthcare.wizard.step1.question'),
    'options' => [
        'yes' => __('healthcare.wizard.step1.yes'),
        'no' => __('healthcare.wizard.step1.no'),
        'unknown' => __('healthcare.wizard.step1.unknown'),
    ],
])
