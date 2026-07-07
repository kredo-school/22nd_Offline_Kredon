<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            // 営業時間の後ろに「description（紹介文）」の箱を新設する
            $table->text('description')->nullable()->after('hours');
        });
    }

    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};