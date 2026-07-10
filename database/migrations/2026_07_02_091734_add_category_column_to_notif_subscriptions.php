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
        Schema::table('notif_subscriptions', function (Blueprint $table) {
            // カテゴリー購読の場合はここに文字列を入れる。モデル購読(spot等)の場合はnullのまま。
            $table->string('category')->nullable()->after('subscribable_id');

            // 既存のポリモーフィックカラムを、カテゴリー購読でも使えるようnullable化
            $table->string('subscribable_type')->nullable()->change();
            $table->unsignedBigInteger('subscribable_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notif_subscriptions', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->string('subscribable_type')->nullable(false)->change();
            $table->unsignedBigInteger('subscribable_id')->nullable(false)->change();
        });
    }
};
