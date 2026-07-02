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
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            // ▼ここから追加▼
            $table->string('name'); // 店名
            $table->string('area'); // エリア（it-east, ayala など）
            $table->string('hours')->nullable(); // 営業時間（空っぽでもOKにする）
            $table->boolean('has_wifi')->default(false); // WIFIの有無（true か false）
            $table->boolean('has_power')->default(false); // コンセントの有無（true か false）
            $table->text('map_url')->nullable(); // Googleマップのリンク
            // ▲ここまで追加▲
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spots');
    }
};
