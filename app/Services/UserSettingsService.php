<?php

namespace App\Services;

use App\Models\CharacterTemp;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\UserKeywordMute;
use App\Models\UserNgWord;
use App\Models\UserSetting;
use Illuminate\Support\Str;

class UserSettingsService
{
    public function ensureSettings(User $user): UserSetting
    {
        $defaultCharacter = CharacterTemp::query()->where('is_default', true)->first()
            ?? CharacterTemp::query()->where('is_active', true)->first();

        return UserSetting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'color_mode'         => 'light',
                'character_temp_id'  => $defaultCharacter?->id,
                'allow_comments'     => true,
                'pre_approval'       => false,
                'ng_word_filter'     => true,
                'ng_word_strength'   => 'standard',
                'spam_detection'     => true,
                'ai_moderation'      => true,
                'notification_settings' => self::defaultNotificationSettings(),
                'privacy_settings'      => self::defaultPrivacySettings(),
                'app_settings'          => self::defaultAppSettings(),
            ]
        );
    }

    public function accountViewData(User $user): object
    {
        $user->loadMissing(['settings.characterTemp']);
        $settings = $this->ensureSettings($user);
        $privacy  = $settings->privacy_settings ?? self::defaultPrivacySettings();
        $notify   = $settings->notification_settings ?? self::defaultNotificationSettings();

        return (object) [
            'name'               => $user->name,
            'username'           => $user->username ?? '',
            'email'              => $user->email,
            'avatar'             => $user->avatarUrl(),
            'bio'                => $user->bio ?? '',
            'plan'               => $user->isPremium() ? 'premium' : 'free',
            'two_factor_enabled' => (bool) $user->two_factor_enabled,
            'created_at'         => $user->created_at?->format('Y-m-d') ?? '',
            'last_login'         => $user->updated_at?->locale('ja')->diffForHumans() ?? '—',
            'posts_count'        => (int) $user->posts_count,
            'theme'              => $this->themeLabel($settings),
            'security_label'     => $user->two_factor_enabled ? 'High' : 'Standard',
            'notify_event'       => (bool) ($notify['event'] ?? true),
            'notify_comment'     => (bool) ($notify['comment'] ?? true),
            'profile_public'       => ! (bool) ($privacy['private_account'] ?? false),
            'notifications'        => $this->recentNotifications($user, 3),
        ];
    }

    public function notificationSettings(User $user): object
    {
        $settings = $this->ensureSettings($user);
        $stored   = $settings->notification_settings ?? self::defaultNotificationSettings();

        $types = [
            ['key' => 'comment', 'label' => 'コメント通知', 'desc' => 'あなたの投稿にコメントがあったときに通知します。', 'icon' => 'fa-regular fa-comment', 'color' => 'blue'],
            ['key' => 'event', 'label' => 'イベント通知', 'desc' => 'イベントの開催・リマインド・キャンセル情報を通知します。', 'icon' => 'fa-solid fa-calendar-days', 'color' => 'purple'],
            ['key' => 'market', 'label' => 'マーケット通知', 'desc' => '出品への反応や価格の変更などを通知します。', 'icon' => 'fa-solid fa-store', 'color' => 'orange'],
            ['key' => 'premium', 'label' => 'プレミアム通知', 'desc' => 'プレミアム特典や限定キャンペーンを通知します。', 'icon' => 'fa-solid fa-crown', 'color' => 'gold'],
        ];

        $channels = [
            ['key' => 'push', 'label' => 'プッシュ通知', 'desc' => 'ブラウザやアプリにプッシュ通知を送信します。', 'icon' => 'fa-solid fa-bell'],
            ['key' => 'email', 'label' => 'メール通知', 'desc' => '登録メールアドレスに通知を送信します。', 'icon' => 'fa-regular fa-envelope'],
        ];

        foreach ($types as &$type) {
            $type['enabled'] = (bool) ($stored[$type['key']] ?? true);
        }
        unset($type);

        foreach ($channels as &$channel) {
            $channel['enabled'] = (bool) ($stored['channel_' . $channel['key']] ?? ($channel['key'] === 'push'));
        }
        unset($channel);

        return (object) [
            'types'          => $types,
            'channels'       => $channels,
            'preview_items'  => $this->recentNotifications($user, 3),
            'status_summary' => [
                'general' => collect($types)->contains(fn ($t) => $t['enabled']) ? '有効' : '無効',
                'push'    => ($stored['channel_push'] ?? true) ? 'オン' : 'オフ',
                'email'   => ($stored['channel_email'] ?? false) ? 'オン' : 'オフ',
            ],
        ];
    }

    public function privacySettings(User $user): object
    {
        $settings = $this->ensureSettings($user);
        $stored   = array_merge(self::defaultPrivacySettings(), $settings->privacy_settings ?? []);

        $visibilityOptions = self::visibilityOptions();
        $locationOptions   = self::locationOptions();
        $dmOptions         = self::dmOptions();

        $account = [
            ['type' => 'toggle', 'key' => 'private_account', 'label' => '非公開アカウント', 'desc' => '承認したユーザーのみ、あなたの投稿やプロフィールを閲覧できます。', 'enabled' => (bool) $stored['private_account']],
            ['type' => 'toggle', 'key' => 'show_online', 'label' => 'オンライン状態を表示', 'desc' => '他のユーザーにオンライン状態を表示します。', 'enabled' => (bool) $stored['show_online']],
            ['type' => 'toggle', 'key' => 'show_activity', 'label' => 'アクティビティを表示', 'desc' => 'コメントやレビューなどの活動状況を他のユーザーに表示します。', 'enabled' => (bool) $stored['show_activity']],
        ];

        $activity = [
            ['type' => 'select', 'key' => 'post_visibility', 'label' => '投稿の公開範囲', 'desc' => 'マーケット出品・スポットレビューなどの投稿の公開先', 'value' => $stored['post_visibility'], 'options' => $visibilityOptions],
            ['type' => 'select', 'key' => 'review_visibility', 'label' => 'レビューの公開範囲', 'desc' => '勉強・観光スポットへのレビューの公開先', 'value' => $stored['review_visibility'], 'options' => $visibilityOptions],
            ['type' => 'toggle', 'key' => 'show_bookmarks', 'label' => '保存リスト・ブックマークを表示', 'desc' => '保存したスポットや投稿をプロフィールに表示します。', 'enabled' => (bool) $stored['show_bookmarks']],
            ['type' => 'toggle', 'key' => 'show_browsing', 'label' => '閲覧履歴を表示', 'desc' => '閲覧したスポットや病院情報を他のユーザーに表示します。', 'enabled' => (bool) $stored['show_browsing']],
        ];

        $location = [
            ['type' => 'toggle', 'key' => 'disable_location', 'label' => '位置情報の共有を無効にする', 'desc' => '投稿やチェックイン時の位置情報を共有しません。', 'enabled' => (bool) $stored['disable_location']],
            ['type' => 'toggle', 'key' => 'approximate_location', 'label' => '詳細な位置情報を表示しない', 'desc' => '市区町村レベルのおおよそのエリアのみ表示します（例: Cebu City）。', 'enabled' => (bool) $stored['approximate_location']],
            ['type' => 'select', 'key' => 'location_visibility', 'label' => '位置情報の閲覧制限', 'desc' => 'スポット投稿に付随する位置情報の公開先', 'value' => $stored['location_visibility'], 'options' => $locationOptions],
        ];

        $message = [
            ['type' => 'select', 'key' => 'dm_setting', 'label' => 'ダイレクトメッセージの受信設定', 'desc' => 'マーケット取引やスポットに関する連絡の受信範囲', 'value' => $stored['dm_setting'], 'options' => $dmOptions],
            ['type' => 'toggle', 'key' => 'show_in_search', 'label' => '検索結果に表示する', 'desc' => 'ユーザー検索やマーケット出品者検索に表示されます。', 'enabled' => (bool) $stored['show_in_search']],
        ];

        return (object) [
            'protection_level' => $stored['private_account'] ? '高' : '標準',
            'account'          => $account,
            'activity'         => $activity,
            'location'         => $location,
            'message'          => $message,
            'preview_summary'  => [
                ['label' => '投稿の公開範囲', 'value' => $visibilityOptions[$stored['post_visibility']] ?? $stored['post_visibility']],
                ['label' => '位置情報', 'value' => $stored['approximate_location'] ? '市区町村レベル' : '詳細'],
                ['label' => 'オンライン状態', 'value' => $stored['show_online'] ? '表示' : '非表示'],
                ['label' => 'メッセージ', 'value' => $dmOptions[$stored['dm_setting']] ?? $stored['dm_setting']],
            ],
            'status_checklist' => [
                ['label' => '非公開アカウント', 'status' => $stored['private_account'] ? 'ON' : 'OFF'],
                ['label' => '位置情報の共有', 'status' => $stored['disable_location'] ? '無効' : '有効'],
                ['label' => 'オンライン状態', 'status' => $stored['show_online'] ? '表示' : '非表示'],
                ['label' => 'メッセージ制限', 'status' => $stored['dm_setting'] === 'all' ? 'なし' : '制限あり'],
            ],
        ];
    }

    public function privacyGuide(): object
    {
        return (object) [
            'updated_at' => '2026年6月1日',
            'sections'   => [
                [
                    'key' => 'market', 'title' => 'マーケット（フリマ）', 'icon' => 'fa-solid fa-store', 'color' => 'orange',
                    'desc' => '中古品の譲渡時に、連絡先などの個人情報が含まれます。',
                    'tips' => ['出品時は本名ではなくユーザー名でのやり取りを推奨します。', '譲渡場所はカフェテリアを選びましょう。'],
                ],
                [
                    'key' => 'study', 'title' => '勉強スポット', 'icon' => 'fa-solid fa-book', 'color' => 'teal',
                    'desc' => 'カフェ、勉強場所の情報共有時に位置情報が公開されることがあります。',
                    'tips' => ['「詳細な位置情報を表示しない」設定で、おおよそのエリアのみ公開できます。'],
                ],
            ],
            'rights' => [
                'いつでもプライバシー設定から公開範囲を変更できます。',
                'プライバシーに関するお問い合わせは kredon.cebu@gmail.com までご連絡ください。',
            ],
        ];
    }

    public function displaySettings(User $user): object
    {
        $settings   = $this->ensureSettings($user);
        $characters = CharacterTemp::query()->where('is_active', true)->orderBy('id')->get();
        $character  = $settings->characterTemp ?? $characters->firstWhere('is_default', true) ?? $characters->first();

        $characterRows = $characters->map(fn (CharacterTemp $c) => [
            'id'      => $c->slug,
            'name'    => $c->name,
            'desc'    => $c->description ?? '',
            'image'   => $c->image_path ?? '',
            'initial' => $c->initial ?? mb_substr($c->name, 0, 1),
            'bg'      => $c->bg_color ?? '#2A87C8',
            'accent'  => $c->accent ?? 'blue',
        ])->values()->all();

        $colorModeLabels = ['light' => 'ライト', 'dark' => 'ダーク', 'system' => 'システム'];

        return (object) [
            'color_mode'   => $settings->color_mode,
            'character_id' => $character?->slug ?? 'kuredon',
            'color_modes'  => [
                ['value' => 'light', 'label' => 'ライト', 'desc' => '明るい背景で読みやすく表示します。', 'icon' => 'fa-regular fa-sun'],
                ['value' => 'dark', 'label' => 'ダーク', 'desc' => '目に優しい暗色テーマで表示します。', 'icon' => 'fa-regular fa-moon'],
                ['value' => 'system', 'label' => 'システム', 'desc' => '端末の設定（ライト/ダーク）に合わせます。', 'icon' => 'fa-solid fa-desktop'],
            ],
            'characters'       => $characterRows,
            'status_summary'   => [
                'color_mode'   => $colorModeLabels[$settings->color_mode] ?? $settings->color_mode,
                'character'    => $character?->name ?? '—',
                'auth_screens' => 'ログイン・新規登録',
            ],
            'preview' => [
                'login_title'    => 'KREDON Cebu へログイン',
                'register_title' => 'ITパーク留学生アカウント作成',
                'sample_post'    => Str::limit($user->bio ?: 'プロフィールを設定してください', 80),
                'sample_user'    => $user->name,
            ],
        ];
    }

    public function appSettings(User $user): object
    {
        $settings = $this->ensureSettings($user);
        $stored   = array_merge(self::defaultAppSettings(), $settings->app_settings ?? []);

        $langLabels = ['ja' => '日本語 (デフォルト)', 'en' => 'English', 'tl' => 'Tagalog'];

        return (object) array_merge($stored, [
            'translate_languages'     => $langLabels,
            'spot_priority_options'   => ['popular' => '人気順', 'nearby' => '近い順', 'recent' => '新着順'],
            'map_priority_options'    => ['spot' => 'スポット優先', 'event' => 'イベント優先', 'mixed' => 'バランス'],
            'app_version'             => config('app.version', '2.3.1'),
            'recommended_spots'       => [],
            'preview_notifications'   => $this->recentNotifications($user, 2),
            'status_summary'          => [
                'data_saver'     => ($stored['data_saver'] ?? false) ? 'オン' : 'オフ',
                'auto_translate' => ($stored['auto_translate'] ?? true)
                    ? 'オン (' . ($langLabels[$stored['translate_language'] ?? 'ja'] ?? '日本語') . ')'
                    : 'オフ',
            ],
        ]);
    }

    public function commentSettings(User $user): object
    {
        $user->loadCount(['blocks', 'keywordMutes', 'ngWords']);
        $user->load([
            'blocks.blockedUser:id,name,username',
            'keywordMutes:id,user_id,keyword',
            'ngWords:id,user_id,word',
        ]);
        $settings = $this->ensureSettings($user);

        $strengthLabels = ['low' => '低', 'standard' => '標準', 'high' => '高'];

        return (object) [
            'allow_comments'     => (bool) $settings->allow_comments,
            'pre_approval'       => (bool) $settings->pre_approval,
            'ng_word_filter'     => (bool) $settings->ng_word_filter,
            'ng_word_strength'   => $settings->ng_word_strength,
            'spam_detection'     => (bool) $settings->spam_detection,
            'ai_moderation'      => (bool) $settings->ai_moderation,
            'blocked_count'      => (int) $user->blocks_count,
            'keyword_mute_count' => (int) $user->keyword_mutes_count,
            'ng_word_count'      => (int) $user->ng_words_count,
            'blocked_users'      => $user->blocks->map(fn (UserBlock $block) => [
                'id'       => $block->id,
                'name'     => $block->blockedUser?->name ?? '不明なユーザー',
                'username' => $block->blockedUser?->username ?? '',
            ])->values()->all(),
            'keyword_mutes'      => $user->keywordMutes->map(fn (UserKeywordMute $mute) => [
                'id'      => $mute->id,
                'keyword' => $mute->keyword,
            ])->values()->all(),
            'user_ng_words'      => $user->ngWords->map(fn (UserNgWord $word) => [
                'id'   => $word->id,
                'word' => $word->word,
            ])->values()->all(),
            'safety_status'      => $this->computeSafetyStatus($settings),
            'preview_post'       => [
                'text'  => Str::limit($user->bio ?: '自己紹介を設定すると、ここにプレビューが表示されます。', 120),
                'time'  => 'プレビュー',
                'image' => false,
            ],
            'safety_features'    => [
                ['label' => 'スパム検出', 'status' => $settings->spam_detection ? '有効' : '無効'],
                ['label' => 'AIモデレーション', 'status' => $settings->ai_moderation ? '有効' : '無効'],
                ['label' => 'NGワードフィルター', 'status' => $settings->ng_word_filter ? '有効' : '無効'],
                ['label' => 'NGワード強度', 'status' => $strengthLabels[$settings->ng_word_strength] ?? '標準'],
            ],
        ];
    }

    public function resetNotificationSettings(User $user): void
    {
        $this->ensureSettings($user)->update([
            'notification_settings' => self::defaultNotificationSettings(),
        ]);
    }

    public function resetAppSettings(User $user): void
    {
        $this->ensureSettings($user)->update([
            'app_settings' => self::defaultAppSettings(),
        ]);
    }

    public static function defaultNotificationSettings(): array
    {
        return [
            'comment'       => true,
            'event'         => true,
            'market'        => false,
            'premium'       => true,
            'channel_push'  => true,
            'channel_email' => false,
        ];
    }

    public static function defaultPrivacySettings(): array
    {
        return [
            'private_account'       => false,
            'show_online'           => true,
            'show_activity'         => false,
            'post_visibility'       => 'members',
            'review_visibility'     => 'members',
            'show_bookmarks'        => true,
            'show_browsing'         => false,
            'disable_location'      => true,
            'approximate_location'  => true,
            'location_visibility'   => 'members',
            'dm_setting'            => 'members',
            'show_in_search'        => true,
        ];
    }

    public static function defaultAppSettings(): array
    {
        return [
            'ai_recommendations'  => true,
            'continue_learning'   => true,
            'auto_translate'      => true,
            'translate_language'  => 'ja',
            'data_saver'          => false,
            'wifi_hd_only'        => true,
            'location_accuracy'   => true,
            'spot_priority'       => 'popular',
            'map_priority'        => 'spot',
        ];
    }

    public function mergeNotificationSettings(array $input): array
    {
        $defaults = self::defaultNotificationSettings();
        foreach (['comment', 'event', 'market', 'premium'] as $key) {
            $defaults[$key] = ! empty($input['notify_' . $key]);
        }
        $defaults['channel_push']  = ! empty($input['channel_push']);
        $defaults['channel_email'] = ! empty($input['channel_email']);

        return $defaults;
    }

    public function mergePrivacySettings(array $input): array
    {
        $defaults = self::defaultPrivacySettings();
        foreach ($defaults as $key => $value) {
            if (is_bool($value)) {
                $defaults[$key] = ! empty($input[$key]);
            } elseif (array_key_exists($key, $input)) {
                $defaults[$key] = $input[$key];
            }
        }

        return $defaults;
    }

    public function mergeAppSettings(array $input): array
    {
        $defaults = self::defaultAppSettings();
        foreach (['ai_recommendations', 'continue_learning', 'auto_translate', 'data_saver', 'wifi_hd_only', 'location_accuracy'] as $boolKey) {
            $defaults[$boolKey] = ! empty($input[$boolKey]);
        }
        if (isset($input['translate_language'])) {
            $defaults['translate_language'] = $input['translate_language'];
        }
        if (isset($input['spot_priority'])) {
            $defaults['spot_priority'] = $input['spot_priority'];
        }
        if (isset($input['map_priority'])) {
            $defaults['map_priority'] = $input['map_priority'];
        }

        return $defaults;
    }

    protected function themeLabel(UserSetting $settings): string
    {
        return match ($settings->color_mode) {
            'dark'   => 'Dark Theme',
            'system' => 'System Theme',
            default  => 'Tropical Theme',
        };
    }

    public function recentNotifications(User $user, int $limit = 5): array
    {
        return Notification::query()
            ->forUser($user->id)
            ->where('status', 'sent')
            ->orderByDesc('sent_at')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn (Notification $notification) => $this->formatNotificationPreview($notification))
            ->values()
            ->all();
    }

    protected function formatNotificationPreview(Notification $notification): array
    {
        $meta = match ($notification->category) {
            'comment' => ['icon' => 'fa-regular fa-comment', 'color' => 'blue'],
            'event'   => ['icon' => 'fa-solid fa-calendar-days', 'color' => 'purple'],
            'market'  => ['icon' => 'fa-solid fa-store', 'color' => 'orange'],
            'premium' => ['icon' => 'fa-solid fa-crown', 'color' => 'gold'],
            default   => ['icon' => 'fa-solid fa-bell', 'color' => 'gray'],
        };

        $timestamp = $notification->sent_at ?? $notification->created_at;

        return [
            'icon'  => $meta['icon'],
            'color' => $meta['color'],
            'text'  => $notification->title ?: ($notification->body ?? ''),
            'time'  => $timestamp?->locale('ja')->diffForHumans() ?? '',
        ];
    }

    protected function computeSafetyStatus(UserSetting $settings): string
    {
        $score = (int) $settings->ng_word_filter
            + (int) $settings->spam_detection
            + (int) $settings->ai_moderation
            + ($settings->ng_word_strength === 'high' ? 1 : 0);

        return match (true) {
            $score >= 4 => '高',
            $score >= 2 => '良好',
            default     => '標準',
        };
    }

    protected static function visibilityOptions(): array
    {
        return [
            'public'  => '全体公開（留学生コミュニティ）',
            'members' => '登録ユーザーのみ',
            'private' => '非公開',
        ];
    }

    protected static function locationOptions(): array
    {
        return [
            'public'  => '全体公開',
            'members' => '登録ユーザーのみ',
            'private' => '非公開',
        ];
    }

    protected static function dmOptions(): array
    {
        return [
            'all'     => 'すべてのユーザー',
            'members' => '登録ユーザーのみ',
            'none'    => '受け取らない',
        ];
    }

}
