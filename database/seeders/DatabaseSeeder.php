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
            SpecialtySeeder::class,
            HospitalSeeder::class,
            FaqCategorySeeder::class,
            FaqSeeder::class,
        ]);
    }
}
