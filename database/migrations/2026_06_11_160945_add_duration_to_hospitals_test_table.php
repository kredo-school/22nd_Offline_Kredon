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
            // after() を使うと、テーブル構造のどこに追加されるか指定できて便利
            $table->integer('duration')->nullable()->after('lng');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals_test', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};
