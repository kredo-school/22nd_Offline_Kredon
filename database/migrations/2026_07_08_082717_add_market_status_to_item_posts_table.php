<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_posts', function (Blueprint $table) {

            $table->string('market_status')
                ->default('available');

            $table->foreignId('reserved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('item_posts', function (Blueprint $table) {

            $table->dropForeign(['reserved_by']);
            $table->dropColumn([
                'market_status',
                'reserved_by'
            ]);

        });
    }
};