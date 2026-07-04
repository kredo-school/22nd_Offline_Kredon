<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$alreadyApplied = [
    '2026_06_30_100010_create_hospitals_table' => 'hospitals',
    '2026_06_30_100011_create_specialties_table' => 'specialties',
    '2026_06_30_100012_create_hospital_specialty_table' => 'hospital_specialty',
];

$batch = (int) DB::table('migrations')->max('batch') + 1;

foreach ($alreadyApplied as $migration => $table) {
    if (!Schema::hasTable($table)) {
        echo "Missing table {$table}, skip marking {$migration}\n";
        continue;
    }

    if (DB::table('migrations')->where('migration', $migration)->exists()) {
        echo "Already recorded: {$migration}\n";
        continue;
    }

    DB::table('migrations')->insert([
        'migration' => $migration,
        'batch' => $batch,
    ]);

    echo "Recorded: {$migration}\n";
}

echo "Done.\n";
