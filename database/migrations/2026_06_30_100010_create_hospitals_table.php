<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->boolean('is_clinic')->default(false);
            $table->boolean('is_jhd_supported')->default(false);
            $table->boolean('is_24_hours')->default(false);
            $table->string('business_hours')->nullable();
            $table->string('closed_days')->nullable();
            $table->string('jhd_hours')->nullable();
            $table->string('jhd_closed_days')->nullable();
            $table->decimal('lat', 10, 8);
            $table->decimal('lng', 11, 8);
            $table->string('address_en')->nullable();
            $table->unsignedInteger('duration_grab')->nullable();
            $table->unsignedInteger('duration_walk')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('guide_tips_ja')->nullable();
            $table->text('guide_tips_en')->nullable();
            $table->string('grab_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
