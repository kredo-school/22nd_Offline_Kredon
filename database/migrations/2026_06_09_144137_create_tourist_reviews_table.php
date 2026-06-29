<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
    {
        Schema::create('tourist_reviews', function (Blueprint $table) {
            $table->id();
            // どのスポットに対する、誰のクチコミかを紐づける
            $table->foreignId('tourist_spot_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 星の数（1〜5）とコメント
            $table->integer('rating')->default(0); 
            $table->text('comment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_reviews');
    }
};
