<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 🌟 Bundleではなく、Blueprintが正解！
        Schema::create('spot_photos', function (Blueprint $table) {
            $table->id();
            // どのスポットの写真かを記録（スポットが消えたら連動して消える）
            $table->foreignId('spot_id')->constrained()->onDelete('cascade');
            // 写真の保存パス
            $table->string('photo_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spot_photos');
    }
};