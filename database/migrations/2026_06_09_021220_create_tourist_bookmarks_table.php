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
        Schema::create('tourist_bookmarks', function (Blueprint $table) {
            $table->id();
            // ユーザーIDと観光スポットIDの組み合わせを記録
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tourist_spot_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // 同じスポットを同じ人が重複して登録できないように制約をかける
            $table->unique(['user_id', 'tourist_spot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_bookmarks');
    }
};
