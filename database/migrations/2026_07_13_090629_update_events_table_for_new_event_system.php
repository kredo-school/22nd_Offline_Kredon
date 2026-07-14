<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {

            if (!Schema::hasColumn('events', 'start_date')) {
                $table->date('start_date')->nullable()->after('location');
            }

            if (!Schema::hasColumn('events', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }

            if (!Schema::hasColumn('events', 'organizer_type')) {
                $table->enum('organizer_type', ['user', 'company'])
                    ->default('user')
                    ->after('end_date');
            }

            if (!Schema::hasColumn('events', 'display_channel')) {
                $table->enum('display_channel', ['event_page', 'share_info'])
                    ->default('event_page')
                    ->after('organizer_type');
            }

            if (!Schema::hasColumn('events', 'is_published')) {
                $table->boolean('is_published')
                    ->default(true)
                    ->after('display_channel');
            }
        });

        if (
            Schema::hasColumn('events', 'event_date') &&
            Schema::hasColumn('events', 'start_date')
        ) {
            DB::statement("
                UPDATE events
                SET start_date = event_date
                WHERE start_date IS NULL
            ");
        }

        if (
            Schema::hasColumn('events', 'start_date') &&
            Schema::hasColumn('events', 'end_date')
        ) {
            DB::statement("
                UPDATE events
                SET end_date = start_date
                WHERE end_date IS NULL
            ");
        }
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {

            if (Schema::hasColumn('events', 'is_published')) {
                $table->dropColumn('is_published');
            }

            if (Schema::hasColumn('events', 'display_channel')) {
                $table->dropColumn('display_channel');
            }

            if (Schema::hasColumn('events', 'organizer_type')) {
                $table->dropColumn('organizer_type');
            }

            if (Schema::hasColumn('events', 'end_date')) {
                $table->dropColumn('end_date');
            }

            if (Schema::hasColumn('events', 'start_date')) {
                $table->dropColumn('start_date');
            }
        });
    }
};