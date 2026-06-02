<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. item_posts があるか確認してから images を作る
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_post_id')->constrained('item_posts')->onDelete('cascade');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};