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
        Schema::table('hospitals_test', function (Blueprint $table) {
            $table->boolean('is_clinic')->default(false);
            $table->integer('duration_grab')->nullable();
            $table->integer('duration_walk')->nullable();
            $table->string('phone_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals_test', function (Blueprint $table) {
            $table->dropColumn(['is_clinic', 'duration_grab', 'duration_walk', 'phone_number']);
        });
    }
};
