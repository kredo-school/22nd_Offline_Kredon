<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('all_reviews', function (Blueprint $table) {
            $table->tinyInteger('customer_vibe')->nullable()->after('rating');
            $table->tinyInteger('eye_fatigue_level')->nullable()->after('customer_vibe');
            $table->tinyInteger('chair_comfort')->nullable()->after('eye_fatigue_level');
            $table->tinyInteger('desk_stability')->nullable()->after('chair_comfort');
        });
    }

    public function down(): void
    {
        Schema::table('all_reviews', function (Blueprint $table) {
            $table->dropColumn(['customer_vibe', 'eye_fatigue_level', 'chair_comfort', 'desk_stability']);
        });
    }
};