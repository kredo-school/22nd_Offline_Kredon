<?php

namespace App\Support\Dummy;

/**
 * ユーザー設定ページ用のダミーデータ集約クラス。
 *
 * 本番DB完成後は、各メソッドの呼び出し元（SettingController）を
 * 実際のModelクエリに差し替えるだけで移行できる。
 */
class SettingDummyData
{
    public static function user(): object
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

    public static function notificationSettings(): object
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

    public static function privacySettings(): object
    {
        $visibilityOptions = [
            'public'  => '全体公開（留学生コミュニティ）',
            'members' => '登録ユーザーのみ',
            'private' => '非公開',
        ];

        $locationOptions = [
            'public'  => '全体公開',
            'members' => '登録ユーザーのみ',
            'private' => '非公開',
        ];

        $dmOptions = [
            'all'     => 'すべてのユーザー',
            'members' => '登録ユーザーのみ',
            'none'    => '受け取らない',
        ];

        return (object) [
            'protection_level' => '高',
            'account' => [
                [
                    'type'    => 'toggle',
                    'key'     => 'private_account',
                    'label'   => '非公開アカウント',
                    'desc'    => '承認したユーザーのみ、あなたの投稿やプロフィールを閲覧できます。',
                    'enabled' => false,
                ],
                [
                    'type'    => 'toggle',
                    'key'     => 'show_online',
                    'label'   => 'オンライン状態を表示',
                    'desc'    => '他のユーザーにオンライン状態を表示します。',
                    'enabled' => true,
                ],
                [
                    'type'    => 'toggle',
                    'key'     => 'show_activity',
                    'label'   => 'アクティビティを表示',
                    'desc'    => 'コメントやレビューなどの活動状況を他のユーザーに表示します。',
                    'enabled' => false,
                ],
            ],
            'activity' => [
                [
                    'type'    => 'select',
                    'key'     => 'post_visibility',
                    'label'   => '投稿の公開範囲',
                    'desc'    => 'マーケット出品・スポットレビューなどの投稿の公開先',
                    'value'   => 'members',
                    'options' => $visibilityOptions,
                ],
                [
                    'type'    => 'select',
                    'key'     => 'review_visibility',
                    'label'   => 'レビューの公開範囲',
                    'desc'    => '勉強・観光スポットへのレビューの公開先',
                    'value'   => 'members',
                    'options' => $visibilityOptions,
                ],
                [
                    'type'    => 'toggle',
                    'key'     => 'show_bookmarks',
                    'label'   => '保存リスト・ブックマークを表示',
                    'desc'    => '保存したスポットや投稿をプロフィールに表示します。',
                    'enabled' => true,
                ],
                [
                    'type'    => 'toggle',
                    'key'     => 'show_browsing',
                    'label'   => '閲覧履歴を表示',
                    'desc'    => '閲覧したスポットや病院情報を他のユーザーに表示します。',
                    'enabled' => false,
                ],
            ],
            'location' => [
                [
                    'type'    => 'toggle',
                    'key'     => 'disable_location',
                    'label'   => '位置情報の共有を無効にする',
                    'desc'    => '投稿やチェックイン時の位置情報を共有しません。',
                    'enabled' => true,
                ],
                [
                    'type'    => 'toggle',
                    'key'     => 'approximate_location',
                    'label'   => '詳細な位置情報を表示しない',
                    'desc'    => '市区町村レベルのおおよそのエリアのみ表示します（例: Cebu City）。',
                    'enabled' => true,
                ],
                [
                    'type'    => 'select',
                    'key'     => 'location_visibility',
                    'label'   => '位置情報の閲覧制限',
                    'desc'    => 'スポット投稿に付随する位置情報の公開先',
                    'value'   => 'members',
                    'options' => $locationOptions,
                ],
            ],
            'message' => [
                [
                    'type'    => 'select',
                    'key'     => 'dm_setting',
                    'label'   => 'ダイレクトメッセージの受信設定',
                    'desc'    => 'マーケット取引やスポットに関する連絡の受信範囲',
                    'value'   => 'members',
                    'options' => $dmOptions,
                ],
                [
                    'type'    => 'toggle',
                    'key'     => 'show_in_search',
                    'label'   => '検索結果に表示する',
                    'desc'    => 'ユーザー検索やマーケット出品者検索に表示されます。',
                    'enabled' => true,
                ],
            ],
            'preview_summary' => [
                ['label' => '投稿の公開範囲', 'value' => '登録ユーザーのみ'],
                ['label' => '位置情報',       'value' => '市区町村レベル'],
                ['label' => 'オンライン状態', 'value' => '表示'],
                ['label' => 'メッセージ',     'value' => '登録ユーザーのみ'],
            ],
            'status_checklist' => [
                ['label' => '非公開アカウント', 'status' => 'OFF'],
                ['label' => '位置情報の共有',   'status' => '無効'],
                ['label' => 'オンライン状態',   'status' => '表示'],
                ['label' => 'メッセージ制限',   'status' => '制限あり'],
            ],
        ];
    }

    public static function privacyGuide(): object
    {
        return (object) [
            'updated_at' => '2026年6月1日',
            'sections'   => [
                [
                    'key'   => 'market',
                    'title' => 'マーケット（フリマ）',
                    'icon'  => 'fa-solid fa-store',
                    'color' => 'orange',
                    'desc'  => '中古品の譲渡時に、連絡先などの個人情報が含まれます。',
                    'tips'  => [
                        '出品時は本名ではなくユーザー名でのやり取りを推奨します。',
                        '譲渡場所はカフェテリアを選びましょう。',
                        'LINE ID や電話番号は、取引が確定するまで公開しないでください。',
                        '不要になった出品は削除し、個人情報が残らないようにしましょう。',
                    ],
                ],
                [
                    'key'   => 'hospital',
                    'title' => '病院ガイド',
                    'icon'  => 'fa-solid fa-hospital',
                    'color' => 'blue',
                    'desc'  => '',
                    'tips'  => [
                        '',
                    ],
                ],
                [
                    'key'   => 'study',
                    'title' => '勉強スポット',
                    'icon'  => 'fa-solid fa-book',
                    'color' => 'teal',
                    'desc'  => 'カフェ、勉強場所の情報共有時に位置情報が公開されることがあります。',
                    'tips'  => [
                        '「詳細な位置情報を表示しない」設定で、おおよそのエリアのみ公開できます。',
                        '定期的に通う場所の特定を避けるため、投稿のタイミングに注意しましょう。',
                        'Wi-Fi 情報など第三者の権利に関わる情報は投稿しないでください。',
                    ],
                ],
                [
                    'key'   => 'tourism',
                    'title' => '観光スポット',
                    'icon'  => 'fa-solid fa-umbrella-beach',
                    'color' => 'purple',
                    'desc'  => '観光地の写真やレビューには、撮影場所や同行者が写り込むことがあります。',
                    'tips'  => [
                        '写真に写り込んだ他人の顔は、投稿前に確認・許可を得ましょう。',
                        'リアルタイム投稿は現在地の特定につながるため、帰宅後の投稿を推奨します。',
                        'プライベートビーチや施設内では、撮影・投稿が禁止の場合があります。現地ルールを確認してください。',
                    ],
                ],
            ],
            'rights' => [
                'いつでもプライバシー設定から公開範囲を変更できます。',
                'アカウント設定から、投稿・レビュー・位置情報のデータ削除をリクエストできます。',
                'マーケット取引相手をブロックし、メッセージを拒否できます。',
                'プライバシーに関するお問い合わせは kredon.cebu@gmail.com までご連絡ください。',
            ],
        ];
    }

    public static function commentSettings(): object
    {
        return (object) [
            'allow_comments'     => true,
            'follower_only'      => false,
            'pre_approval'       => false,
            'ng_word_filter'     => true,
            'ng_word_strength'   => 'standard', // low | standard | high
            'spam_detection'     => true,
            'ai_moderation'      => true,
            'blocked_count'      => 12,
            'muted_count'        => 8,
            'keyword_mute_count' => 5,
            'safety_status'      => '良好',
            'preview_post' => [
                'text'  => '今日はマクタン島のビーチが最高でした！🌴 来週のイベントも楽しみですね。',
                'time'  => '15分前',
                'image' => true,
            ],
            'preview_comments' => [
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
            'safety_features' => [
                ['label' => 'スパム検出',         'status' => '有効'],
                ['label' => 'AIモデレーション',   'status' => '有効'],
                ['label' => 'NGワードフィルター', 'status' => '有効'],
                ['label' => 'コメント制限',       'status' => '標準'],
            ],
        ];
    }
}