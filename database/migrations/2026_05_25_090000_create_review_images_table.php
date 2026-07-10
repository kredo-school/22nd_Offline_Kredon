<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        // 💡 もし 'review_images' テーブルが存在「しない」場合だけ作成する処理
        if (!Schema::hasTable('review_images')) {
            Schema::create('review_images', function (Blueprint $table) {
                $table->id();
                
                $table->foreignId('review_id')->constrained()->onDelete('cascade');
                
                // store the path of the image in the storage
                $table->string('image_path');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_images');
    }
};
