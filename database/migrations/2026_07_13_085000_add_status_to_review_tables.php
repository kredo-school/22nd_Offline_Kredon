<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['all_reviews', 'reviews', 'tourist_reviews'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->enum('status', ['published', 'unpublished'])
                  ->default('published')
                  ->after('rating');
            });
        }
    }

    public function down(): void
    {
        foreach (['all_reviews', 'reviews', 'tourist_reviews'] as $table) {
            Schema::table($table, fn (Blueprint $t) => $t->dropColumn('status'));
        }
    }
};