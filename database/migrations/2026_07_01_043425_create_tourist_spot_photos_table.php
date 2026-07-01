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
        Schema::create('tourist_spot_photos', function (Blueprint $table) {
            $table->id();
            // 🌟 どの観光スポットの写真かを紐づける（親が消えたら写真も消える設定）
            $table->foreignId('tourist_spot_id')->constrained()->onDelete('cascade');
            // 🌟 写真のパス（URL）を保存するカラム
            $table->string('photo_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_spot_photos');
    }
};
