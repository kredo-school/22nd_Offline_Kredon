<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spot_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // 同じユーザーが同じスポットを2回ブックマークできないようにするバリア
            $table->unique(['user_id', 'spot_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
};