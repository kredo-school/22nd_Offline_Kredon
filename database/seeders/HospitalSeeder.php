<?php

namespace Database\Seeders;

use App\Models\Hospital;
use App\Models\Specialty;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        $jhdSpecialtySlugs = ['internal_medicine', 'surgery', 'respiratory'];
        $clinicSpecialtySlugs = ['general_outpatient'];

        $hospitals = [
            [
                'name' => 'Cebu Doctors University Hospital',
                'short_name' => 'Cebu Doc',
                'is_clinic' => false,
                'is_jhd_supported' => true,
                'is_24_hours' => true,
                'jhd_hours' => '08:00 - 17:00',
                'jhd_closed_days' => '日曜',
                'duration_grab' => 20,
                'duration_walk' => null,
                'supports_grab' => true,
                'lat' => 10.313400,
                'lng' => 123.894500,
                'address_en' => 'Osmena Blvd., Cebu City, Cebu',
                'phone_number' => '+63-917-571-7436',
                'guide_tips_ja' => 'キャッシュレス受診を希望する場合、事前にJHDに連絡する必要があります。',
                'guide_tips_en' => 'For cashless visits, please contact JHD in advance.',
                'grab_link' => null,
                'specialty_slugs' => $jhdSpecialtySlugs,
                'images' => [
                    [
                        'url' => 'hospitals/cebudoc-ext.jpg',
                        'caption' => '外観', 'sort_order' => 0
                    ],
                    [
                        'url' => 'hospitals/cebudoc.jpg',
                        'caption' => '入口', 'sort_order' => 1
                    ],
                ],
            ],
            [
                'name' => 'Chong Hua Hospital - Mandaue City',
                'short_name' => 'Chong Hua Mandaue',
                'is_clinic' => false,
                'is_jhd_supported' => true,
                'is_24_hours' => true,
                'jhd_hours' => '08:00 - 17:00',
                'jhd_closed_days' => '日曜',
                'duration_grab' => 22,
                'duration_walk' => null,
                'supports_grab' => true,
                'lat' => 10.32289991,
                'lng' => 123.9309904,
                'address_en' => 'Medical Arts Building, 8F, Unit 809',
                'phone_number' => '+63-917-791-2177',
                'guide_tips_ja' => 'キャッシュレス受診を希望する場合、事前にJHDに連絡する必要があります。',
                'guide_tips_en' => 'For cashless visits, please contact JHD in advance.',
                'grab_link' => null,
                'specialty_slugs' => $jhdSpecialtySlugs,
                'images' => [
                    [
                        'url' => 'hospitals/chonghua-ext.jpg',
                        'caption' => '外観', 'sort_order' => 0
                    ],
                    
                    [
                        'url' => 'hospitals/chonhua-ent.jpg',
                        'caption' => '入口', 'sort_order' => 1
                    ],
                    [
                        'url' => 'hospitals/chonghua-jhd.jpg',
                        'caption' => 'jhd', 'sort_order' => 2
                    ],
                ],
            ],
            [
                'name' => 'Maxicare Clinic',
                'short_name' => 'Maxicare',
                'is_clinic' => true,
                'is_jhd_supported' => false,
                'is_24_hours' => false,
                'business_hours' => '06:00 - 22:00',
                'closed_days' => 'なし',
                'duration_grab' => null,
                'duration_walk' => 1,
                'lat' => 10.3277739,
                'lng' => 123.9063473,
                'address_en' => 'Skyrise 4, Cebu City, Cebu',
                'guide_tips_ja' => '支払いは電子決済のみ。18時以降が比較的空いています。',
                'guide_tips_en' => 'Electronic payment only. Often less busy after 6 PM.',
                'specialty_slugs' => $clinicSpecialtySlugs,
                'images' => [
                    [
                        'url' => 'hospitals/maxicare-ext.jpg',
                        'caption' => '外観', 'sort_order' => 0
                    ],
                    [
                        'url' => 'hospitals/maxicare-int.jpg',
                        'caption' => '内観', 'sort_order' => 1
                    ],
                ],
            ],
            [
                'name' => 'Aventus Medical Care Clinic',
                'short_name' => 'Aventus',
                'is_clinic' => true,
                'is_jhd_supported' => false,
                'is_24_hours' => false,
                'business_hours' => '07:00 - 17:00',
                'closed_days' => '日曜',
                'duration_grab' => null,
                'duration_walk' => 6,
                'lat' => 10.329754,
                'lng' => 123.905825,
                'address_en' => 'Unit 203 TGU Tower Block 1 Lot 6 & 7 Phase 1 Asia Town, Cebu City 6000 Cebu',
                'guide_tips_ja' => 'クレジット決済可。',
                'guide_tips_en' => 'Credit cards accepted.',
                'specialty_slugs' => $clinicSpecialtySlugs,
                'images' => [
                    [
                        'url' => 'hospitals/aventus.jpg',
                        'caption' => '外観', 'sort_order' => 0
                    ],
                ],
            ],
        ];

        foreach ($hospitals as $data) {
            $specialtySlugs = $data['specialty_slugs'];
            $images = $data['images'];
            unset($data['specialty_slugs'], $data['images']);

            $hospital = Hospital::updateOrCreate(
                ['name' => $data['name']],
                $data
            );

            $specialtyIds = Specialty::whereIn('slug', $specialtySlugs)->pluck('id');
            $hospital->specialties()->sync($specialtyIds);

            $hospital->images()->delete();
            foreach ($images as $image) {
                $hospital->images()->create($image);
            }
        }
    }
}
