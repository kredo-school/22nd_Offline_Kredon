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
            $table->enum('status', ['published', 'draft', 'unpublished'])
                ->default('published')
                ->after('photo_path');
        });
    }

    public function down()
    {
        Schema::table('tourist_spots', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
