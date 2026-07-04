<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //テストユーザーの作成
        $user = User::first() ?? User::factory()->create(['name' => 'Test User']);

        // working place, three pic 
        $review1 = Review::create([
            'user_id' => $user->id,
            'location_id' => 1, // 例: 勤務先のID
            'title' => 'Great Place to Work',
            'comment' => 'I had a wonderful experience working here. The environment is supportive and the team is fantastic.',
            "rating" => 5,
        ]);

        // 画像の作成
        ReviewImage::create(['review_id' => $review1->id, 'image_path' => 'reviews/sample1.jpg']);
        ReviewImage::create(['review_id' => $review1->id, 'image_path' => 'reviews/sample2.jpg']);
        ReviewImage::create(['review_id' => $review1->id, 'image_path' => 'reviews/sample3.jpg']);

        // Hospital, one pic
        $review2 = Review::create([
            'user_id' => $user->id,
            'location_id' => 2, // 例: 病院のID
            'title' => 'Excellent Healthcare',
            'comment' => 'The medical staff was very attentive and the facilities were top-notch. I highly recommend this hospital.',
            "rating" => 4,
        ]);

        // 画像の作成
        ReviewImage::create(['review_id' => $review2->id, 'image_path' => 'reviews/sample_hospital1.jpg']);

        // Tourism, no pic
        Review::create([
            'user_id' => $user->id,
            'location_id' => 3, // 例: 観光地のID
            'title' => 'Amazing Tourist Spot',
            'comment' => 'The scenery was breathtaking and there were so many activities to enjoy. I had an unforgettable trip!',
            "rating" => 5,
        ]);

        // Hospital, two pic
        $review3 = Review::create([
            'user_id' => $user->id,
            'location_id' => 2, // 例: 病院のID
            'title' => 'Good Service but Long Wait Time at Hospital',
            'comment' => 'The staff was friendly and the care was good, but I had to wait for a long time before being seen.',
            "rating" => 3,
        ]);

        // 画像の作成
        ReviewImage::create(['review_id' => $review3->id, 'image_path' => 'reviews/sample_hospital2.jpg']);
        ReviewImage::create(['review_id' => $review3->id, 'image_path' => 'reviews/sample_hospital3.jpg']);

        // Tourism, one pic
        $review4 = Review::create([
            'user_id' => $user->id,
            'location_id' => 3, // 例: 観光地のID
            'title' => 'Beautiful Beach',
            'comment' => 'The beach was stunning with clear blue water and soft sand. It was the perfect place to relax and unwind.',
            "rating" => 5,
        ]);

        // 画像の作成
        ReviewImage::create(['review_id' => $review4->id, 'image_path' => 'reviews/sample_beach1.jpg']);
    }
}
