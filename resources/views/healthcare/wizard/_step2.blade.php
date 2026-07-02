@include('healthcare.wizard._wizard_card', [
    'step' => 2,
    'question' => 'JHDサポートを利用しますか?',
    'options' => [
        'yes' => '利用する',
        'no' => '利用しない',
    ],
])
