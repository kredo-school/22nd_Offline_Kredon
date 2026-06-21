<?php

namespace App\Http\Controllers;

use App\Support\Dummy\SettingDummyData;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = SettingDummyData::user();
    }

    public function index()
    {
    return redirect()->route('settings.account');
    }

    public function display()
    {
        return view('settings._display', ['user' => $this->user]);
    }

    
    public function app()
    {
        return view('settings._app', ['user' => $this->user]);
    }

    public function updateAccount(Request $request)
    {
        // TODO: auth()->user()->update($request->validated());
        return back()->with('success', '保存しました');
    }

    public function updateNotification(Request $request)
    {
        // TODO: 通知設定の保存
        return back()->with('success', '保存しました');
    }

    public function updateComment(Request $request)
    {
        // TODO: コメント・安全設定の保存
        return back()->with('success', '保存しました');
    }

    public function updatePrivacy(Request $request)
    {
        // TODO: プライバシー設定の保存
        return back()->with('success', '保存しました');
    }
}