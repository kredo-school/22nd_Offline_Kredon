<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 不要になった動線回避度を削除し、BGMのボリュームを追加
            $table->dropColumn('traffic_avoidance_rating');
            $table->integer('bgm_volume_level')->default(0)->after('wall_seat_rating');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('traffic_avoidance_rating')->default(0);
            $table->dropColumn('bgm_volume_level');
        });
    }
};