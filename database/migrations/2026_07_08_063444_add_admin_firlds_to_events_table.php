<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {

            if (!Schema::hasColumn('events', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('events', 'organizer_type')) {
                $table->enum('organizer_type', ['user', 'company'])
                    ->default('user')
                    ->after('user_id');
            }

            if (!Schema::hasColumn('events', 'display_channel')) {
                $table->enum('display_channel', ['event_page', 'share_info'])
                    ->default('event_page')
                    ->after('organizer_type');
            }
        });

        if (Schema::hasColumn('events', 'end_date')) {
            DB::table('events')
                ->whereNull('end_date')
                ->update([
                    'end_date' => DB::raw('start_date')
                ]);
        }
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {

            if (Schema::hasColumn('events', 'display_channel')) {
                $table->dropColumn('display_channel');
            }

            if (Schema::hasColumn('events', 'organizer_type')) {
                $table->dropColumn('organizer_type');
            }

            if (Schema::hasColumn('events', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};