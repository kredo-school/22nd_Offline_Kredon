<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CharacterTempSeeder::class,
            NgWordSeeder::class,
            UserSettingSeeder::class,
            SpotSeeder::class,
            PostSeeder::class,
            TouristSpotSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
