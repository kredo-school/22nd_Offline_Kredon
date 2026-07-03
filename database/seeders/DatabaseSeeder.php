<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => bcrypt('password'),
            ]
        );

        $this->call([
            UserSeeder::class,
            CharacterTempSeeder::class,
            NgWordSeeder::class,
            UserSettingSeeder::class,
            SpotSeeder::class,
            PostSeeder::class,
            TouristSpotSeeder::class,
            NotificationSeeder::class,
            SpecialtySeeder::class,
            HospitalSeeder::class,
            FaqCategorySeeder::class,
            FaqSeeder::class,
        ]);
    }
}
