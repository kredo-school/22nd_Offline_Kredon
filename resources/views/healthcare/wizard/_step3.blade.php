@include('healthcare.wizard._wizard_card', [
    'step' => 3,
    'question' => '現在の状況を教えてください',
    'options' => [
        'mild' => '軽い症状・相談したい',
        'hospital' => '今日病院へ行きたい',
        'emergency' => '緊急性がある',
    ],
])
