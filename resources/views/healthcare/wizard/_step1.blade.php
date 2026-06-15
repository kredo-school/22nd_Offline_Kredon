@include('healthcare.wizard._wizard_card',[

    'step'=>1,

    'question' =>'海外旅行保険に加入していますか?',

    'option' =>[
         'yes' =>'加入している'
         'no'  =>'加入していない'
         'unknown'=>'わからない'
    ]
])
    