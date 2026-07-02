<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            [
                'slug' => 'internal_medicine',
                'name' => '内科',
                'name_en' => 'Internal Medicine',
                'badge_class' => 'bg-primary-subtle text-primary',
                'sort_order' => 1,
            ],
            [
                'slug' => 'surgery',
                'name' => '外科',
                'name_en' => 'Surgery',
                'badge_class' => 'bg-danger-subtle text-danger',
                'sort_order' => 2,
            ],
            [
                'slug' => 'respiratory',
                'name' => '呼吸器',
                'name_en' => 'Respiratory',
                'badge_class' => 'bg-info-subtle text-info',
                'sort_order' => 3,
            ],
            [
                'slug' => 'general_outpatient',
                'name' => '一般外来',
                'name_en' => 'General Outpatient',
                'badge_class' => 'bg-secondary-subtle text-secondary',
                'sort_order' => 4,
            ],
        ];

        foreach ($specialties as $specialty) {
            Specialty::updateOrCreate(
                ['slug' => $specialty['slug']],
                $specialty
            );
        }
    }
}
