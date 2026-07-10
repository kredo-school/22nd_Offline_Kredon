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
            'last_login'         => $user->updated_at?->locale('en')->diffForHumans() ?? '—',
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
            ['key' => 'comment', 'label' => 'Comment Notifications', 'desc' => 'Notify you when someone comments on your posts.', 'icon' => 'fa-regular fa-comment', 'color' => 'blue'],
            ['key' => 'event', 'label' => 'Event Notifications', 'desc' => 'Notify you about event schedules, reminders, and cancellations.', 'icon' => 'fa-solid fa-calendar-days', 'color' => 'purple'],
            ['key' => 'market', 'label' => 'Market Notifications', 'desc' => 'Notify you about listing responses and price changes.', 'icon' => 'fa-solid fa-store', 'color' => 'orange'],
            ['key' => 'premium', 'label' => 'Premium Notifications', 'desc' => 'Notify you about premium benefits and exclusive campaigns.', 'icon' => 'fa-solid fa-crown', 'color' => 'gold'],
        ];

        $channels = [
            ['key' => 'push', 'label' => 'Push Notifications', 'desc' => 'Send push notifications to your browser or app.', 'icon' => 'fa-solid fa-bell'],
            ['key' => 'email', 'label' => 'Email Notifications', 'desc' => 'Send notifications to your registered email address.', 'icon' => 'fa-regular fa-envelope'],
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
                'general' => collect($types)->contains(fn ($t) => $t['enabled']) ? 'Enabled' : 'Disabled',
                'push'    => ($stored['channel_push'] ?? true) ? 'On' : 'Off',
                'email'   => ($stored['channel_email'] ?? false) ? 'On' : 'Off',
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
            ['type' => 'toggle', 'key' => 'private_account', 'label' => 'Private Account', 'desc' => 'Only approved users can view your posts and profile.', 'enabled' => (bool) $stored['private_account']],
            ['type' => 'toggle', 'key' => 'show_online', 'label' => 'Show Online Status', 'desc' => 'Display your online status to other users.', 'enabled' => (bool) $stored['show_online']],
            ['type' => 'toggle', 'key' => 'show_activity', 'label' => 'Show Activity', 'desc' => 'Show your activity such as comments and reviews to other users.', 'enabled' => (bool) $stored['show_activity']],
        ];

        $activity = [
            ['type' => 'select', 'key' => 'post_visibility', 'label' => 'Post Visibility', 'desc' => 'Who can see your market listings, spot reviews, and other posts', 'value' => $stored['post_visibility'], 'options' => $visibilityOptions],
            ['type' => 'select', 'key' => 'review_visibility', 'label' => 'Review Visibility', 'desc' => 'Who can see your study and tourist spot reviews', 'value' => $stored['review_visibility'], 'options' => $visibilityOptions],
            ['type' => 'toggle', 'key' => 'show_bookmarks', 'label' => 'Show Saved Lists & Bookmarks', 'desc' => 'Display saved spots and posts on your profile.', 'enabled' => (bool) $stored['show_bookmarks']],
            ['type' => 'toggle', 'key' => 'show_browsing', 'label' => 'Show Browsing History', 'desc' => 'Show spots and hospital pages you have viewed to other users.', 'enabled' => (bool) $stored['show_browsing']],
        ];

        $location = [
            ['type' => 'toggle', 'key' => 'disable_location', 'label' => 'Disable Location Sharing', 'desc' => 'Do not share location when posting or checking in.', 'enabled' => (bool) $stored['disable_location']],
            ['type' => 'toggle', 'key' => 'approximate_location', 'label' => 'Hide Precise Location', 'desc' => 'Show only an approximate area at city level (e.g. Cebu City).', 'enabled' => (bool) $stored['approximate_location']],
            ['type' => 'select', 'key' => 'location_visibility', 'label' => 'Location Visibility', 'desc' => 'Who can see location attached to spot posts', 'value' => $stored['location_visibility'], 'options' => $locationOptions],
        ];

        $message = [
            ['type' => 'select', 'key' => 'dm_setting', 'label' => 'Direct Message Settings', 'desc' => 'Who can send you messages about market deals and spots', 'value' => $stored['dm_setting'], 'options' => $dmOptions],
            ['type' => 'toggle', 'key' => 'show_in_search', 'label' => 'Show in Search Results', 'desc' => 'Appear in user and market seller search results.', 'enabled' => (bool) $stored['show_in_search']],
        ];

        return (object) [
            'protection_level' => $stored['private_account'] ? 'High' : 'Standard',
            'account'          => $account,
            'activity'         => $activity,
            'location'         => $location,
            'message'          => $message,
            'preview_summary'  => [
                ['label' => 'Post Visibility', 'value' => $visibilityOptions[$stored['post_visibility']] ?? $stored['post_visibility']],
                ['label' => 'Location', 'value' => $stored['approximate_location'] ? 'City level' : 'Precise'],
                ['label' => 'Online Status', 'value' => $stored['show_online'] ? 'Visible' : 'Hidden'],
                ['label' => 'Messages', 'value' => $dmOptions[$stored['dm_setting']] ?? $stored['dm_setting']],
            ],
            'status_checklist' => [
                ['label' => 'Private Account', 'status' => $stored['private_account'] ? 'ON' : 'OFF'],
                ['label' => 'Location Sharing', 'status' => $stored['disable_location'] ? 'Disabled' : 'Enabled'],
                ['label' => 'Online Status', 'status' => $stored['show_online'] ? 'Visible' : 'Hidden'],
                ['label' => 'Message Restrictions', 'status' => $stored['dm_setting'] === 'all' ? 'None' : 'Restricted'],
            ],
        ];
    }

    public function privacyGuide(): object
    {
        return (object) [
            'updated_at' => 'June 1, 2026',
            'sections'   => [
                [
                    'key' => 'market', 'title' => 'Market (Flea Market)', 'icon' => 'fa-solid fa-store', 'color' => 'orange',
                    'desc' => 'Personal information such as contact details may be included when transferring secondhand items.',
                    'tips' => ['Use your username rather than your real name when listing items.', 'Choose a campus cafeteria as the handoff location.'],
                ],
                [
                    'key' => 'study', 'title' => 'Study Spots', 'icon' => 'fa-solid fa-book', 'color' => 'teal',
                    'desc' => 'Location may be shared when posting about cafes and study spots.',
                    'tips' => ['Use "Hide Precise Location" to share only an approximate area.'],
                ],
            ],
            'rights' => [
                'You can change visibility anytime in Privacy settings.',
                'For privacy inquiries, contact kredon.cebu@gmail.com.',
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

        $colorModeLabels = ['light' => 'Light', 'dark' => 'Dark', 'system' => 'System'];

        return (object) [
            'color_mode'   => $settings->color_mode,
            'character_id' => $character?->slug ?? 'kuredon',
            'color_modes'  => [
                ['value' => 'light', 'label' => 'Light', 'desc' => 'Display with a bright background for easy reading.', 'icon' => 'fa-regular fa-sun'],
                ['value' => 'dark', 'label' => 'Dark', 'desc' => 'Display with a dark theme that is easier on the eyes.', 'icon' => 'fa-regular fa-moon'],
                ['value' => 'system', 'label' => 'System', 'desc' => 'Follow your device setting (light/dark).', 'icon' => 'fa-solid fa-desktop'],
            ],
            'characters'       => $characterRows,
            'status_summary'   => [
                'color_mode'   => $colorModeLabels[$settings->color_mode] ?? $settings->color_mode,
                'character'    => $character?->name ?? '—',
                'auth_screens' => 'Login & Sign Up',
            ],
            'preview' => [
                'login_title'    => 'Log in to KREDON Cebu',
                'register_title' => 'Create an IT Park Student Account',
                'sample_post'    => Str::limit($user->bio ?: 'Please set up your profile', 80),
                'sample_user'    => $user->name,
            ],
        ];
    }

    public function appSettings(User $user): object
    {
        $settings = $this->ensureSettings($user);
        $stored   = array_merge(self::defaultAppSettings(), $settings->app_settings ?? []);

        $langLabels = ['ja' => 'Japanese (Default)', 'en' => 'English', 'tl' => 'Tagalog'];

        return (object) array_merge($stored, [
            'translate_languages'     => $langLabels,
            'spot_priority_options'   => ['popular' => 'Most Popular', 'nearby' => 'Nearest', 'recent' => 'Newest'],
            'map_priority_options'    => ['spot' => 'Spots First', 'event' => 'Events First', 'mixed' => 'Balanced'],
            'app_version'             => config('app.version', '2.3.1'),
            'recommended_spots'       => [],
            'preview_notifications'   => $this->recentNotifications($user, 2),
            'status_summary'          => [
                'data_saver'     => ($stored['data_saver'] ?? false) ? 'On' : 'Off',
                'auto_translate' => ($stored['auto_translate'] ?? true)
                    ? 'On (' . ($langLabels[$stored['translate_language'] ?? 'ja'] ?? 'Japanese') . ')'
                    : 'Off',
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

        $strengthLabels = ['low' => 'Low', 'standard' => 'Standard', 'high' => 'High'];

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
                'name'     => $block->blockedUser?->name ?? 'Unknown User',
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
                'text'  => Str::limit($user->bio ?: 'Set a bio to see a preview here.', 120),
                'time'  => 'Preview',
                'image' => false,
            ],
            'safety_features'    => [
                ['label' => 'Spam Detection', 'status' => $settings->spam_detection ? 'Enabled' : 'Disabled'],
                ['label' => 'AI Moderation', 'status' => $settings->ai_moderation ? 'Enabled' : 'Disabled'],
                ['label' => 'NG Word Filter', 'status' => $settings->ng_word_filter ? 'Enabled' : 'Disabled'],
                ['label' => 'NG Word Strength', 'status' => $strengthLabels[$settings->ng_word_strength] ?? 'Standard'],
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
            'time'  => $timestamp?->locale('en')->diffForHumans() ?? '',
        ];
    }

    protected function computeSafetyStatus(UserSetting $settings): string
    {
        $score = (int) $settings->ng_word_filter
            + (int) $settings->spam_detection
            + (int) $settings->ai_moderation
            + ($settings->ng_word_strength === 'high' ? 1 : 0);

        return match (true) {
            $score >= 4 => 'High',
            $score >= 2 => 'Good',
            default     => 'Standard',
        };
    }

    protected static function visibilityOptions(): array
    {
        return [
            'public'  => 'Public (Student Community)',
            'members' => 'Registered Users Only',
            'private' => 'Private',
        ];
    }

    protected static function locationOptions(): array
    {
        return [
            'public'  => 'Public',
            'members' => 'Registered Users Only',
            'private' => 'Private',
        ];
    }

    protected static function dmOptions(): array
    {
        return [
            'all'     => 'All Users',
            'members' => 'Registered Users Only',
            'none'    => 'Do Not Accept',
        ];
    }

}
