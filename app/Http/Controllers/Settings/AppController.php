<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Support\Dummy\SettingDummyData;
use Illuminate\Http\Request;

class AppController extends Controller
{
    protected object $user;

    public function __construct()
    {
        $this->user = SettingDummyData::user();
    }

    public function app()
    {
        return view('settings._app', [
            'user' => $this->user,
            'app'  => SettingDummyData::appSettings(),
        ]);
    }

    public function updateApp(Request $request)
    {
        // TODO: auth()->user()->update($request->validated());
        // TODO: 更新後、ライブプレビューに反映されるようにフロントエンドへ信号を送る
        return back()->with('success', 'アプリ設定を保存しました');
    }
}
