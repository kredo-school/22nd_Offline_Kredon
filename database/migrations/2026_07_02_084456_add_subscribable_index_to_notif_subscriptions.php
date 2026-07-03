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
        Schema::table('notif_subscriptions', function (Blueprint $table) {
            $table->index(['subscribable_type', 'subscribable_id', 'notify_on', 'is_active'], 'notif_subs_lookup_index');
        });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notif_subscriptions', function (Blueprint $table) {
            $table->dropIndex('notif_subs_lookup_index');
        });
    }
};
