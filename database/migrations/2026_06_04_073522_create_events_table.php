<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('category')->nullable();

            $table->text('description')->nullable();

            $table->string('location')->nullable();

            // ← event_date を start_date に変更
            $table->date('start_date')->nullable();

            // ← 新規追加
            $table->date('end_date')->nullable();

            // ← 新規追加
            $table->enum('organizer_type', ['user','company'])
                ->default('user');

            // ← 新規追加
            $table->enum('display_channel', ['event_page','share_info'])
                ->default('event_page');

            // ← 新規追加
            $table->boolean('is_published')
                ->default(true);

            $table->string('image1')->nullable();

            $table->string('image2')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};