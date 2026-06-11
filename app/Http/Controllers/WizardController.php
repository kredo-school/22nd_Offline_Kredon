<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class WizardController extends Controller
{
    // 質問データ（キーの間にカンマが必要です）
    private $wizardData = [

        1 => ['question' => 'キャッシュレスで受診したいですか？', 'options' => ['yes' => 'はい', 'no' => 'いいえ']],

        // 2 => ['question' => '日本語対応が必要ですか？',      'options' => ['yes' => 'はい', 'no' => 'いいえ']],
        
        // 3 => ['question' => '現在の状態は？', 'options' => ['重度' => '', 'mactan' => 'マクタン']],
    ];

    public function start() {

        session()->forget('wizard_answers');
        // 最初のステップ用のデータをセット
        return view('healthcare.wizard.step1', [
            'step'     => 1,
            'question' => $this->wizardData[1]['question'],
            'options'  => $this->wizardData[1]['options']
        ]);
    }

    public function step(Request $request, $step) {

        // 存在チェック
        if(!isset($this->wizardData[$step])) { abort(404); }

        $validOptions = array_keys($this->wizardData[$step]['options']);

        // Rule::in
        $request->validate([
            'answer' => ['required', Rule::in($validOptions)]
        ]);

        session(['wizard_answers.' . $step => $request->answer]);

        $nextStep = (int)$step + 1;

        // 3ステップを超えたら終了
        if ($nextStep > 3) {
            return redirect()->route('wizard.result');
        }

        // 次のステップを表示
        return view('healthcare.wizard.step' . $nextStep, [
            'step'      => $nextStep,
            'question'  => $this->wizardData[$nextStep]['question'],
            'options'   => $this->wizardData[$nextStep]['options']
        ]);
    }
}