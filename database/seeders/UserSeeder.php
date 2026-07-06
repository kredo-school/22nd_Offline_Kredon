<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * 開発・検証用ユーザー（パスワードはすべて password）
     */
    public function run(): void
    {
        $users = [
            [
                'name'               => 'クレどん',
                'username'           => 'kredon_official',
                'email'              => 'kredon.cebu@gmail.com',
                'bio'                => 'セブ島をもっと楽しく! 🌴 スポット・イベント・ローカル情報を発信中!',
                'role'               => 3,
                'two_factor_enabled' => true,
                'posts_count'        => 128,
            ],
            [
                'name'               => 'Maria Santos',
                'username'           => 'maria_cebu',
                'email'              => 'maria@example.com',
                'bio'                => 'Cebu IT Park で勉強中 📚',
                'role'               => 2,
                'two_factor_enabled' => false,
                'posts_count'        => 42,
            ],
            [
                'name'               => 'John Miller',
                'username'           => 'john_m',
                'email'              => 'john@example.com',
                'bio'                => 'Spot reviews & market finds.',
                'role'               => 2,
                'two_factor_enabled' => false,
                'posts_count'        => 19,
            ],
            [
                'name'               => 'Sarah Chen',
                'username'           => 'sarah_c',
                'email'              => 'sarah@example.com',
                'bio'                => 'Privacy first 🔒',
                'role'               => 2,
                'two_factor_enabled' => false,
                'posts_count'        => 7,
            ],
            [
                'name'               => 'ken',
                'username'           => 'ken',
                'email'              => 'ken@example.com',
                'bio'                => 'KREDON ユーザー',
                'role'               => 1,
                'two_factor_enabled' => false,
                'posts_count'        => 3,
            ],
        ];

        foreach ($users as $data) {
            User::query()->updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );
        }
    }
}
