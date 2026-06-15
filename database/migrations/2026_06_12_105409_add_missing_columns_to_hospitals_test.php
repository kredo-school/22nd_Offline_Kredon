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
            if (!Schema::hasColumn('hospitals_test', 'short_name'))        $table->string('short_name')->nullable()->after('name');

            if (!Schema::hasColumn('hospitals_test', 'is_clinic')) $table->boolean('is_clinic')->default(false)->after('type');

            if (!Schema::hasColumn('hospitals_test', 'duration_grab')) $table->integer('duration_grab')->nullable()->afte('is_jhd_supported');

            if (!Schema::hasColumn('hospitals_test', 'duration_walk')) $table->integer('duration_walk')->nullable()->after('duration_grab');

            if (!Schema::hasColumn('hospitals_test', 'closed_days')) $table->string('closed_days')->nullable()->after('business_hours');
            
            if (!Schema::hasColumn('hospitals_test', 'phone_number')) $table->string('phone_number')->nullable()->after('closed_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals_test', function (Blueprint $table) {
            //
        });
    }
};
