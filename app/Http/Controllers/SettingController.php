<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $user;

    public function __construct()
    {
        // 本番環境になったらここを差し替える
        // $this->user = auth()->user();

        $this->user = $this->dummyUser();
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
            'notification' => $this->dummyNotificationSettings(),
        ]);
    }

    public function comment()
    {
        return view('settings._comment', [
            'user'    => $this->user,
            'comment' => $this->dummyCommentSettings(),
        ]);
    }

    public function privacy()
    {
        return view('settings._privacy', ['user' => $this->user]);
    }

    public function app()
    {
        return view('settings._app', ['user' => $this->user]);
    }

    private function dummyUser(): object
    {
        return (object) [
            'name'               => 'クレどん',
            'username'           => 'kredon_official',
            'email'              => 'kredon.cebu@gmail.com',
            'avatar'             => null,
            'bio'                => 'セブ島をもっと楽しく! 🌴 スポット・イベント・ローカル情報を発信中!',
            'plan'               => 'premium',
            'two_factor_enabled' => true,
            'created_at'         => '2024-01-15',
            'last_login'         => '2時間前',
            'posts_count'        => 128,
            'theme'              => 'Tropical Theme',
            'security_label'     => 'High',
            'notify_event'       => true,
            'notify_comment'     => false,
            'profile_public'     => true,
            'preview_event'      => [
                'title' => 'Cebu Anime Fest 2026',
                'date'  => 'March 15, 2026',
            ],
            'notifications'      => [
                [
                    'icon'  => 'fa-heart',
                    'color' => 'pink',
                    'text'  => 'Mariaさんがあなたの投稿にいいねしました',
                    'time'  => '5分前',
                ],
                [
                    'icon'  => 'fa-comment',
                    'color' => 'blue',
                    'text'  => 'Johnさんがレビューにコメントしました',
                    'time'  => '1時間前',
                ],
                [
                    'icon'  => 'fa-calendar-days',
                    'color' => 'green',
                    'text'  => '新しいイベントが公開されました',
                    'time'  => '3時間前',
                ],
            ],
        ];
    }

    private function dummyNotificationSettings(): object
    {
        return (object) [
            'types' => [
                [
                    'key'     => 'comment',
                    'label'   => 'コメント通知',
                    'desc'    => 'あなたの投稿にコメントがあったときに通知します。',
                    'icon'    => 'fa-regular fa-comment',
                    'color'   => 'blue',
                    'enabled' => true,
                ],
                [
                    'key'     => 'follow',
                    'label'   => 'フォロー通知',
                    'desc'    => 'あなたをフォローしたときに通知します。',
                    'icon'    => 'fa-solid fa-user-plus',
                    'color'   => 'teal',
                    'enabled' => true,
                ],
                [
                    'key'     => 'event',
                    'label'   => 'イベント通知',
                    'desc'    => 'イベントの開催・リマインド・キャンセル情報を通知します。',
                    'icon'    => 'fa-solid fa-calendar-days',
                    'color'   => 'purple',
                    'enabled' => true,
                ],
                [
                    'key'     => 'market',
                    'label'   => 'マーケット通知',
                    'desc'    => '出品への反応や価格の変更などを通知します。',
                    'icon'    => 'fa-solid fa-store',
                    'color'   => 'orange',
                    'enabled' => false,
                ],
                [
                    'key'     => 'premium',
                    'label'   => 'プレミアム通知',
                    'desc'    => 'プレミアム特典や限定キャンペーンを通知します。',
                    'icon'    => 'fa-solid fa-crown',
                    'color'   => 'gold',
                    'enabled' => true,
                ],
            ],
            'channels' => [
                [
                    'key'     => 'push',
                    'label'   => 'プッシュ通知',
                    'desc'    => 'ブラウザやアプリにプッシュ通知を送信します。',
                    'icon'    => 'fa-solid fa-bell',
                    'enabled' => true,
                ],
                [
                    'key'     => 'email',
                    'label'   => 'メール通知',
                    'desc'    => '登録メールアドレスに通知を送信します。',
                    'icon'    => 'fa-regular fa-envelope',
                    'enabled' => false,
                ],
            ],
            'preview_items' => [
                [
                    'icon'  => 'fa-regular fa-comment',
                    'color' => 'blue',
                    'text'  => 'CyberNekoさんがあなたの投稿にコメントしました',
                    'time'  => '1時間前',
                ],
                [
                    'icon'  => 'fa-solid fa-user-plus',
                    'color' => 'teal',
                    'text'  => 'Mariaさんがあなたをフォローしました',
                    'time'  => '2時間前',
                ],
                [
                    'icon'  => 'fa-solid fa-calendar-days',
                    'color' => 'purple',
                    'text'  => 'Cebu Anime Fest 2026 のリマインド',
                    'time'  => '3時間前',
                ],
                [
                    'icon'  => 'fa-solid fa-crown',
                    'color' => 'gold',
                    'text'  => 'プレミアム限定イベントのお知らせ',
                    'time'  => '1日前',
                ],
            ],
            'status_summary' => [
                'general' => '有効',
                'push'    => 'オン',
                'email'   => 'オフ',
            ],
        ];
    }

    private function dummyCommentSettings(): object
    {
        return (object) [
            'allow_comments'       => true,
            'follower_only'        => false,
            'pre_approval'         => false,
            'ng_word_filter'       => true,
            'ng_word_strength'     => 'standard', // low | standard | high
            'spam_detection'       => true,
            'ai_moderation'        => true,
            'blocked_count'        => 12,
            'muted_count'          => 8,
            'keyword_mute_count'   => 5,
            'safety_status'        => '良好',
            'preview_post'         => [
                'text'     => '今日はマクタン島のビーチが最高でした！🌴 来週のイベントも楽しみですね。',
                'time'     => '15分前',
                'image'    => true,
            ],
            'preview_comments'       => [
                [
                    'name'    => 'Maria',
                    'premium' => true,
                    'text'    => '素敵な写真ですね！次回一緒に行きましょう 🌊',
                    'time'    => '10分前',
                ],
                [
                    'name'    => 'John',
                    'premium' => false,
                    'text'    => 'このスポットの詳細を教えてください！',
                    'time'    => '8分前',
                ],
                [
                    'name'    => 'Sarah',
                    'premium' => true,
                    'text'    => 'イベント情報ありがとうございます ✨',
                    'time'    => '5分前',
                ],
            ],
            'safety_features'      => [
                ['label' => 'スパム検出',       'status' => '有効'],
                ['label' => 'AIモデレーション', 'status' => '有効'],
                ['label' => 'NGワードフィルター', 'status' => '有効'],
                ['label' => 'コメント制限',     'status' => '標準'],
            ],
        ];
    }

    public function updateComment(Request $request)
    {
        // TODO: コメント・安全設定の保存
        return back()->with('success', '保存しました');
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

    public function updatePrivacy(Request $request)
    {
        // TODO: プライバシー設定の保存
        return back()->with('success', '保存しました');
    }
}
