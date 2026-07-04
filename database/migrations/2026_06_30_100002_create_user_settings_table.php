<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('color_mode')->default('light');
            $table->foreignId('character_temp_id')->nullable()->constrained('character_temps')->nullOnDelete();

            $table->boolean('allow_comments')->default(true);
            $table->boolean('pre_approval')->default(false);
            $table->boolean('ng_word_filter')->default(true);
            $table->string('ng_word_strength')->default('standard');
            $table->boolean('spam_detection')->default(true);
            $table->boolean('ai_moderation')->default(true);

            $table->json('notification_settings')->nullable();
            $table->json('privacy_settings')->nullable();
            $table->json('app_settings')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
