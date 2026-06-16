<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    // ダミーデータ（本番では auth()->user() に差し替え）& objectにキャスト効果: 本番移行時にbladeの書き換えの必要がなくなる
    private function dummyUser(): object
    {
        return (object) [
            'name'           => 'テストユーザー',
            'email'          => 'test@kredon.com',
            'avatar'         => null,
            'bio'            => 'セブ在住です',
            'plan'           => 'free',
            'created_at'     => '2024-01-15',
            'notify_event'   => true,
            'notify_comment' => false,
            'profile_public' => true,
        ];
    }

    // ── 表示 ──────────────────────────────
    public function account()      { return view('settings.account',      ['user' => $this->dummyUser()]); }
    public function display()      { return view('settings.display',      ['user' => $this->dummyUser()]); }
    public function notification() { return view('settings.notification', ['user' => $this->dummyUser()]); }
    public function comment()      { return view('settings.comment',      ['user' => $this->dummyUser()]); }
    public function privacy()      { return view('settings.privacy',      ['user' => $this->dummyUser()]); }
    public function app()          { return view('settings.app',          ['user' => $this->dummyUser()]); }

    // 保存（中身はDB完成後に実装） 
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

    public function updatePrivacy(Request $request)
    {
        // TODO: プライバシー設定の保存
        return back()->with('success', '保存しました');
    }
}