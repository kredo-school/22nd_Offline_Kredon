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
         Schema::rename('item_posts', 'home_feed_temps');

        // ソート機能用カラムが無ければ追加
        Schema::table('home_feed_temps', function ($table) {
            if (!Schema::hasColumn('home_feed_temps', 'comments_count')) {
                $table->unsignedInteger('comments_count')->default(0);
            }
            if (!Schema::hasColumn('home_feed_temps', 'reviews_count')) {
                $table->unsignedInteger('reviews_count')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_feed_temps', function ($table) {
            $table->dropColumn(['comments_count', 'reviews_count']);
        });

        Schema::rename('home_feed_temps', 'item_posts');
    }
};