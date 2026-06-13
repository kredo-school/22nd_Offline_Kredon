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
       Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // 'basic'（基礎期）か 'advanced'（発展期）を入れる箱
            $table->string('title');    // Tipsのタイトル
            $table->text('text');       // Tipsの具体的な内容文
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tips');
    }
};
