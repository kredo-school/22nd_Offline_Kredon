<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hospitals_test')->insert([
            [
                'name' => 'Cebu Doctors University Hospital',
                'short_name' => 'Cebu Doc',
                'type' => 'hospital',
                'is_clinic' => false,
                'is_jhd_supported' => true,
                'duration_grab' => 20,
                'duration_walk' => null,
                'lat' => 10.313400,
                'lng' => 123.894500,
                'address_en' => 'Osmena Blvd., Cebu City, Cebu',
                'business_hours' => '08:00 - 17:00',
                'closed_days' => 'Sun',
                'phone_number' => '+63-917-571-7436',
                'guide_tips_ja' => 'キャッシュレス受診を希望する場合、事前にJHDに連絡する必要があります。',
                'image_path' => 'images/hospital.jpg',
                'category_ids' => '1,2,3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chong Hua Hospital - Mandaue City',
                'short_name' => 'Chong Hua',
                'type' => 'hospital',
                'is_clinic' => false,
                'is_jhd_supported' => true,
                'duration_grab' => 22,
                'duration_walk' => null, 
                'lat' => 10.32289991,
                'lng' => 123.9309904,
                'address_en' => 'Medical Arts Building, 8F, Unit 809',
                'business_hours' => '08:00 - 17:00',
                'closed_days' => 'Sun',
                'phone_number' => '+63-917-791-2177',
                'guide_tips_ja' => 'キャッシュレス受診を希望する場合、事前にJHDに連絡する必要があります。',
                'image_path' => 'images/hospital.jpg',
                'category_ids' => '1,2,3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maxicare Clinic',
                'short_name' => 'Maxicare',
                'type' => 'clinic',
                'is_clinic' => true,
                'is_jhd_supported' => false,
                'duration_grab' => null, // nullを入れる
                'duration_walk' => 1,
                'lat' => 10.3277739,
                'lng' => 123.9063473,
                'address_en' => 'Skyrise 4, Cebu City, Cebu',
                'business_hours' => '06:00 - 22:00',
                'closed_days' => 'None',
                'phone_number' => null, // 追加
                'guide_tips_ja' => '支払いは電子決済のみ。比較的18時以降が空いています。',
                'image_path' => 'images/hospital.jpg',
                'category_ids' => '1,2,3,4,5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
            'name' => 'Aventus Medical Care Clinic',
            'short_name' => 'Aventus',
            'type' => 'clinic',
            'is_clinic' => true,
            'is_jhd_supported' => false,
            'duration_grab' => null, // nullを入れる
            'duration_walk' => 6,
            'lat' => 10.329754,
            'lng' => 123.905825,
            'address_en' => 'Unit 203 TGU Tower Block 1 Lot 6 & 7 Phase 1 Asia Town, Cebu City 6000 Cebu',
            'business_hours' => '07:00 - 17:00',
            'closed_days' => 'Sun',
            'phone_number' => null,
            'guide_tips_ja' => 'クレジット決済可。',
            'image_path' => 'images/hospital.jpg',
            'category_ids' => '1,2,3,4,5',
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}