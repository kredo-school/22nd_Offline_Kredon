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
        Schema::create('all_reviews', function (Blueprint $table) {
            $table->id();
            // userが消されたらレビューも消す
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // 場所が消されたらレビューも消す
            // $table->foreignId('location_id')->constrained()->onDelete('cascade'); //後で実行
            $table->unsignedBigInteger('location_id'); //仮置き
            // 評価
            $table->float('rating')->unsigned();
            // reviewの内容
            $table->string('title');
            $table->text('comment')->nullable(); //コメントなくてもOK
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
