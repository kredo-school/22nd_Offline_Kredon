<?php

namespace Database\Seeders;

use App\Models\CharacterTemp;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\UserKeywordMute;
use App\Models\UserSetting;
use App\Services\UserSettingsService;
use Illuminate\Database\Seeder;

class UserSettingSeeder extends Seeder
{
    public function run(): void
    {
        $kuredon  = CharacterTemp::query()->where('slug', 'kuredon')->first();
        $kurejina = CharacterTemp::query()->where('slug', 'kurejina')->first();

        $profiles = [
            'kredon.cebu@gmail.com' => [
                'color_mode'        => 'light',
                'character_temp_id' => $kuredon?->id,
                'ng_word_strength'  => 'standard',
                'notification_settings' => [
                    'comment' => true, 'event' => true, 'market' => false, 'premium' => true,
                    'channel_push' => true, 'channel_email' => false,
                ],
                'privacy_settings' => UserSettingsService::defaultPrivacySettings(),
                'app_settings'     => UserSettingsService::defaultAppSettings(),
            ],
            'maria@example.com' => [
                'color_mode'        => 'dark',
                'character_temp_id' => $kurejina?->id,
                'ng_word_strength'  => 'high',
                'ng_word_filter'    => true,
                'notification_settings' => array_merge(UserSettingsService::defaultNotificationSettings(), [
                    'market' => true,
                ]),
            ],
            'john@example.com' => [
                'color_mode'       => 'system',
                'ng_word_strength' => 'standard',
                'privacy_settings' => array_merge(UserSettingsService::defaultPrivacySettings(), [
                    'private_account' => true,
                    'show_online'     => false,
                    'post_visibility' => 'private',
                ]),
            ],
            'sarah@example.com' => [
                'ng_word_strength' => 'low',
                'notification_settings' => [
                    'comment' => false, 'event' => false, 'market' => false, 'premium' => false,
                    'channel_push' => false, 'channel_email' => false,
                ],
                'privacy_settings' => array_merge(UserSettingsService::defaultPrivacySettings(), [
                    'show_in_search' => false,
                    'dm_setting'     => 'none',
                ]),
            ],
            'ken@example.com' => [
                'color_mode' => 'light',
                'app_settings' => array_merge(UserSettingsService::defaultAppSettings(), [
                    'data_saver' => true,
                    'auto_translate' => false,
                ]),
            ],
        ];

        $users = User::query()->whereIn('email', array_keys($profiles))->get()->keyBy('email');

        foreach ($profiles as $email => $overrides) {
            $user = $users->get($email);
            if (! $user) {
                continue;
            }

            UserSetting::query()->updateOrCreate(
                ['user_id' => $user->id],
                array_merge([
                    'allow_comments'     => true,
                    'pre_approval'       => false,
                    'ng_word_filter'     => true,
                    'ng_word_strength'   => 'standard',
                    'spam_detection'     => true,
                    'ai_moderation'      => true,
                    'notification_settings' => UserSettingsService::defaultNotificationSettings(),
                    'privacy_settings'      => UserSettingsService::defaultPrivacySettings(),
                    'app_settings'          => UserSettingsService::defaultAppSettings(),
                    'character_temp_id'     => $kuredon?->id,
                    'color_mode'            => 'light',
                ], $overrides)
            );
        }

        $maria = $users->get('maria@example.com');
        $john  = $users->get('john@example.com');
        if ($maria && $john) {
            UserBlock::query()->updateOrCreate(
                ['user_id' => $maria->id, 'blocked_user_id' => $john->id]
            );
        }

        if ($maria) {
            UserKeywordMute::query()->updateOrCreate(
                ['user_id' => $maria->id, 'keyword' => 'spam']
            );
        }
    }
}
