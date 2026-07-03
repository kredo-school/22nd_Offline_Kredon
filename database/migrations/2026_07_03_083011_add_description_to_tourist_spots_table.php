<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
    {
        Schema::table('tourist_spots', function (Blueprint $table) {
            // 🌟 概要を保存する description カラムを追加（空っぽでもエラーにならないよう nullable をつけます）
            // hours カラムの後ろに追加するように指定します
            $table->text('description')->nullable()->after('hours');
        });
    }

    public function down()
    {
        Schema::table('tourist_spots', function (Blueprint $table) {
            // 🌟 戻す時は description カラムを削除
            $table->dropColumn('description');
        });
    }
};
