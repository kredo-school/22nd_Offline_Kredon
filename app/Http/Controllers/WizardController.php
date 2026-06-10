<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WizardController extends Controller
{
    // wizardスタート
    public function start() {

        session()->forget('wizard_answers');
        return view('wizard.step1');
    }

    public function step(Request $request, $step) {

    // validation: もしも回答がなかったらつきかえす
    $request->validate([
        'answer' => 'required',
    ]);

    // セッションに保存 (配列形式)
    session(['wizard_answers.' . $step => $request->answer]);

    // 3. 次のステップ判定
    if ($step < 3) {
        return view('wizard.step' . ($step + 1));
    }

    // 4. 終了
    return redirect()->route('wizard.result');
    }
}
