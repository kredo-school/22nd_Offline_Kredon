<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 既存のコメント等の後ろに新しいカラムを追加
            $table->string('title')->nullable()->after('stay_time_level'); // タイトル
            $table->integer('rating')->default(0)->after('title');          // 全体評価（星1〜5）
            $table->string('photo_path')->nullable()->after('rating');      // 写真のパス
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // ロールバック用に削除の指示も書いておく
            $table->dropColumn(['title', 'rating', 'photo_path']);
        });
    }
};
