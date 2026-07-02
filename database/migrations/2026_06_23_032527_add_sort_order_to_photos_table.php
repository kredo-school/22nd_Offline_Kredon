<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderToPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 🌟 'photos' ではなく 'spot_photos' に追加する！
        Schema::table('spot_photos', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('photo_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 🌟 ロールバック用も 'spot_photos' に直す！
        Schema::table('spot_photos', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
}