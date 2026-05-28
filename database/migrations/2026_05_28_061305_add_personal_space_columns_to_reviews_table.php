<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 死角度（dead_spot_rating）の後ろに、パーソナルスペース特化の2つの評価軸を追加
            $table->integer('wall_seat_rating')->default(0)->after('dead_spot_rating');       // 壁際・角席の確保しやすさ
            $table->integer('traffic_avoidance_rating')->default(0)->after('wall_seat_rating'); // 人の動線からの外れ具合
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // ロールバック（やり直し）用の処理
            $table->dropColumn(['wall_seat_rating', 'traffic_avoidance_rating']);
        });
    }
};