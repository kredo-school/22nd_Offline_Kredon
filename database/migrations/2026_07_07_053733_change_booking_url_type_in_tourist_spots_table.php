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
        // string から text に変更！
        $table->text('booking_url')->nullable()->change();
    });
}

public function down()
{
    Schema::table('tourist_spots', function (Blueprint $table) {
        // 元に戻す時の処理
        $table->string('booking_url', 255)->nullable()->change();
    });
}
};
