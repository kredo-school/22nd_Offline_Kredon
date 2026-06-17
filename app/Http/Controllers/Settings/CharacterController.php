// app/Http/Controllers/Settings/CharacterController.php
<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\CharacterTemp;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    // キャラクター選択画面
    public function index()
    {
        $characters = CharacterTemp::active()->get();

        // 本番前にauth()->user()に切り替え
        $currentCharacterId = 1; // ダミー

        return view('settings.character', compact('characters', 'currentCharacterId'));
    }

    // キャラクター変更を保存
    public function update(Request $request)
    {
        $request->validate([
            'character_temp_id' => 'required|exists:character_temps,id',
        ]);

        // 本番前にコメントアウトを外す
        // auth()->user()->update([
        //     'character_temp_id' => $request->character_temp_id,
        // ]);

        return back()->with('success', 'キャラクターを変更しました');
    }
}