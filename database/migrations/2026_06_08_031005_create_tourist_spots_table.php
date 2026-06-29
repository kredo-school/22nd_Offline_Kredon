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
        Schema::create('tourist_spots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('area');
            $table->string('hours')->nullable();
            $table->string('budget')->nullable();
            $table->string('photo_path')->nullable();
            
            // 4つの体験フラグ
            $table->boolean('has_activity')->default(false);
            $table->boolean('has_view')->default(false);
            $table->boolean('has_shopping')->default(false);
            $table->boolean('has_food')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_spots');
    }
};
