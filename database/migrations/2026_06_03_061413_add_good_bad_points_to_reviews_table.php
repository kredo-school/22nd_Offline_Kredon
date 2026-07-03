<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 🌟 既存のテーブルに good_point と bad_point の箱（文字列型・空っぽOK）を追加！
            $table->string('good_point')->nullable()->after('desk_stability');
            $table->string('bad_point')->nullable()->after('good_point');
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // 元に戻す時の処理
            $table->dropColumn(['good_point', 'bad_point']);
        });
    }
};