<?php

namespace Database\Seeders;

use App\Models\TouristBookmark;
use App\Models\TouristReview;
use App\Models\TouristSpot;
use App\Models\User;
use Illuminate\Database\Seeder;

class TouristSpotSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::query()->whereIn('email', [
            'kredon.cebu@gmail.com',
            'maria@example.com',
            'john@example.com',
            'sarah@example.com',
        ])->get()->keyBy('email');

        if ($users->isEmpty()) {
            return;
        }

        $owner = $users->get('kredon.cebu@gmail.com') ?? $users->first();
        $reviewUsers = $users->values();

        $spots = [
            [
                'name'          => 'マクタン島ビーチ',
                'area'          => 'mactan',
                'hours'         => '6:00 - 18:00',
                'budget'        => '無料',
                'has_activity'  => true,
                'has_view'      => true,
                'has_shopping'  => false,
                'has_food'      => true,
                'reviews'       => 4,
                'bookmarks'     => 6,
            ],
            [
                'name'          => 'シーフードマーケット',
                'area'          => 'mactan',
                'hours'         => '10:00 - 20:00',
                'budget'        => '500-1500 PHP',
                'has_activity'  => false,
                'has_view'      => false,
                'has_shopping'  => true,
                'has_food'      => true,
                'reviews'       => 2,
                'bookmarks'     => 3,
            ],
            [
                'name'          => 'テンプル・オブ・レア',
                'area'          => 'cebu-city',
                'hours'         => '8:00 - 17:00',
                'budget'        => '100 PHP',
                'has_activity'  => true,
                'has_view'      => true,
                'has_shopping'  => false,
                'has_food'      => false,
                'reviews'       => 5,
                'bookmarks'     => 4,
            ],
            [
                'name'          => 'オスロブ・ホエールシャーク',
                'area'          => 'oslob',
                'hours'         => '5:00 - 12:00',
                'budget'        => '3000 PHP〜',
                'has_activity'  => true,
                'has_view'      => true,
                'has_shopping'  => false,
                'has_food'      => true,
                'reviews'       => 1,
                'bookmarks'     => 2,
            ],
        ];

        foreach ($spots as $data) {
            $reviewCount = $data['reviews'];
            $bookmarkCount = $data['bookmarks'];
            unset($data['reviews'], $data['bookmarks']);

            $spot = TouristSpot::query()->firstOrCreate(
                ['name' => $data['name'], 'area' => $data['area']],
                array_merge($data, ['user_id' => $owner->id])
            );

            $existingReviews = TouristReview::query()->where('tourist_spot_id', $spot->id)->count();
            for ($i = $existingReviews; $i < $reviewCount; $i++) {
                $author = $reviewUsers[$i % $reviewUsers->count()];
                TouristReview::query()->create([
                    'tourist_spot_id' => $spot->id,
                    'user_id'         => $author->id,
                    'rating'          => rand(3, 5),
                    'comment'         => 'シードデータ: 観光口コミ ' . ($i + 1),
                ]);
            }

            $existingBookmarks = TouristBookmark::query()->where('tourist_spot_id', $spot->id)->count();
            for ($i = $existingBookmarks; $i < $bookmarkCount; $i++) {
                $bookmarker = $reviewUsers[$i % $reviewUsers->count()];
                TouristBookmark::query()->firstOrCreate([
                    'user_id'         => $bookmarker->id,
                    'tourist_spot_id' => $spot->id,
                ]);
            }
        }
    }
}
