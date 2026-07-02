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
            // 予約サイトのURLを保存するカラムを予算（budget）の後ろに追加
            $table->string('booking_url')->nullable()->after('budget');
        });
    }

    public function down()
    {
        Schema::table('tourist_spots', function (Blueprint $table) {
            $table->dropColumn('booking_url');
        });
    }
};
