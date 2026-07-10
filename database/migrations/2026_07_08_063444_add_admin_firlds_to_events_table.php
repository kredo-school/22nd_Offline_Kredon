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
            // 投稿者（不足していたので追加）
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->nullOnDelete();

            // 主催者種別・表示先
            $table->enum('organizer_type', ['user', 'company'])
                ->default('user')->after('user_id');
            $table->enum('display_channel', ['event_page', 'share_info'])
                ->default('event_page')->after('organizer_type');
        });

        // end_dateが未設定のレコードがあれば念のため埋める
        DB::table('events')
            ->whereNull('end_date')
            ->update(['end_date' => DB::raw('start_date')]);
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['organizer_type', 'display_channel']);
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};