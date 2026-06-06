<?php

namespace Database\Seeders;
use App\Models\Event;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title'      => 'JEE in Cebu',
            'start_date' => '2026-06-20 16:00',
            'end_date'   => '2026-06-20 18:00',
            'location'   => 'ITパーク周辺',
        ]);

        Event::create([
            'title'      => 'ツナフェスティバル',
            'start_date' => '2026-06-25 18:00',
            'location'   => 'Cafeteria',
        ]);
        
        for ($i = 1; $i <= 10; $i++) {
             Event::create ([
            'title'      => 'ツナフェスティバル',
            'start_date' => '2026-06-25 18:00',
            'location'   => 'Cafeteria',
            ]);
        }
    }
}
