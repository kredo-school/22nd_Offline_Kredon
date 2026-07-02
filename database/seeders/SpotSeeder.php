<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use App\Models\Review;
use App\Models\Spot;
use App\Models\User;
use Illuminate\Database\Seeder;

class SpotSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()->whereIn('email', [
            'kredon.cebu@gmail.com',
            'maria@example.com',
            'john@example.com',
            'sarah@example.com',
            'ken@example.com',
        ])->get()->keyBy('email');

        if ($users->isEmpty()) {
            return;
        }

        $owner = $users->get('kredon.cebu@gmail.com') ?? $users->first();

        $spots = [
            [
                'name'      => 'ITパークカフェ',
                'area'      => 'it-park',
                'hours'     => '9:00 - 18:00',
                'has_wifi'  => true,
                'has_power' => true,
                'reviews'   => 3,
                'bookmarks' => 5,
            ],
            [
                'name'      => 'アヤラ・コワーキング',
                'area'      => 'ayala',
                'hours'     => '9:00 - 18:00',
                'has_wifi'  => true,
                'has_power' => true,
                'reviews'   => 2,
                'bookmarks' => 3,
            ],
            [
                'name'      => 'SMシティ・スタディラounge',
                'area'      => 'sm-city',
                'hours'     => '10:00 - 21:00',
                'has_wifi'  => true,
                'has_power' => true,
                'reviews'   => 5,
                'bookmarks' => 2,
            ],
            [
                'name'      => 'IT Park 24h カフェ',
                'area'      => 'it-park',
                'hours'     => '24時間',
                'has_wifi'  => true,
                'has_power' => true,
                'reviews'   => 1,
                'bookmarks' => 4,
            ],
            [
                'name'      => 'マクタン空港ラウンジ近く',
                'area'      => 'mactan',
                'hours'     => '6:00 - 22:00',
                'has_wifi'  => true,
                'has_power' => false,
                'reviews'   => 0,
                'bookmarks' => 1,
            ],
        ];

        $reviewUsers = $users->values();

        foreach ($spots as $data) {
            $reviewCount = $data['reviews'];
            $bookmarkCount = $data['bookmarks'];
            unset($data['reviews'], $data['bookmarks']);

            $spot = Spot::query()->firstOrCreate(
                ['name' => $data['name'], 'area' => $data['area']],
                array_merge($data, ['user_id' => $owner->id])
            );

            $existingReviews = Review::query()->where('spot_id', $spot->id)->count();
            for ($i = $existingReviews; $i < $reviewCount; $i++) {
                $author = $reviewUsers[$i % $reviewUsers->count()];
                Review::query()->create([
                    'spot_id'           => $spot->id,
                    'user_id'           => $author->id,
                    'dead_spot_rating'  => rand(3, 5),
                    'aircon_level'      => rand(2, 5),
                    'stay_time_level'   => rand(3, 5),
                    'rating'            => rand(3, 5),
                    'comment'           => 'シードデータ: 口コミ ' . ($i + 1),
                ]);
            }

            $existingBookmarks = Bookmark::query()->where('spot_id', $spot->id)->count();
            for ($i = $existingBookmarks; $i < $bookmarkCount; $i++) {
                $bookmarker = $reviewUsers[$i % $reviewUsers->count()];
                Bookmark::query()->firstOrCreate([
                    'user_id' => $bookmarker->id,
                    'spot_id' => $spot->id,
                ]);
            }
        }
    }
}
