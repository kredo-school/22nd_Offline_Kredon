<?php

namespace App\Http\Controllers;

use App\Support\Dummy\SettingDummyData;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $user;

    public function __construct()
    {
        // 本番環境になったらここを差し替える
        // $this->user = auth()->user();

        $this->user = SettingDummyData::user();
    }

    public function index()
    {
        return redirect()->route('settings.account');
    }

    public function account()
    {
        return view('settings._account', ['user' => $this->user]);
    }

    public function display()
    {
        return view('settings._display', ['user' => $this->user]);
    }

    public function notification()
    {
        return view('settings._notification', [
            'user'         => $this->user,
            'notification' => SettingDummyData::notificationSettings(),
        ]);
    }

    public function comment()
    {
        return view('settings._comment', [
            'user'    => $this->user,
            'comment' => SettingDummyData::commentSettings(),
        ]);
    }

    public function privacy()
    {
        return view('settings._privacy', [
            'user'    => $this->user,
            'privacy' => SettingDummyData::privacySettings(),
        ]);
    }

    public function privacyGuide()
    {
        return view('settings._privacy_guide', [
            'user'  => $this->user,
            'guide' => SettingDummyData::privacyGuide(),
        ]);
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