<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Support\Dummy\SettingDummyData;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    protected object $user;

    public function __construct()
    {
        $this->user = SettingDummyData::user();
    }

    public function display()
    {
        return view('settings._display', [
            'user'    => $this->user,
            'display' => SettingDummyData::displaySettings(),
        ]);
    }

    public function updateDisplay(Request $request)
    {
        // TODO: auth()->user()->update($request->validated());
        return back()->with('success', '表示設定を保存しました');
    }
}
