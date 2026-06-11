<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hospitals_test', function (Blueprint $table) {
        $table->id();
            $table->string('name');                      // JSON多言語キー
            $table->string('type');                      // 'hospital' or 'clinic'
            $table->boolean('is_jhd_supported')->default(false); // キャッシュレス有無
            $table->decimal('lat', 10, 8);               // 緯度
            $table->decimal('lng', 11, 8);               // 経度
            $table->string('address_en')->nullable();    // Grab用英語住所
            $table->text('business_hours')->nullable();  // 営業時間
            $table->text('guide_tips_ja')->nullable();   // 到着後の案内
            $table->string('image_path')->nullable();    // 画像パス
            $table->string('category_ids')->nullable();  // 診療科IDの格納用
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals_test');
    }
};
