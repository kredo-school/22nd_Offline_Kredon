@include('healthcare.wizard._wizard_card', [
    'step' => 3,
    'question' => __('healthcare.wizard.step3.question'),
    'options' => [
        'mild' => __('healthcare.wizard.step3.mild'),
        'hospital' => __('healthcare.wizard.step3.hospital'),
        'emergency' => __('healthcare.wizard.step3.emergency'),
    ],
])
