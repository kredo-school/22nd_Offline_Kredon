<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            // 第一発見者（登録したユーザー）を記録する箱
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            // 写真のパスを保存する箱
            $table->string('photo_path')->nullable()->after('has_power');
        });
    }

    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'photo_path']);
        });
    }
};