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
            CharacterTempSeeder::class,
            NgWordSeeder::class,
            UserSeeder::class,
            UserSettingSeeder::class,
        ]);
    }
}
