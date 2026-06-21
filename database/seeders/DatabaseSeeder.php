<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::UpdateOrCreate(
            ['email' => 'test@example.com'], 
            [                                
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );
        // 追加したシーダーを呼び出す
        $this->call([
            FaqCategoyTestSeeder::class,
            FaqTestSeeder::class,
        ]);
    }
}
