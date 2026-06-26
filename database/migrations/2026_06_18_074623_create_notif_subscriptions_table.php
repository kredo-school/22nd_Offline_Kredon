<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// item入荷通知（気になる登録できるようにする）
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notif_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // polymorphic: Spot, Market, Item など将来の対象拡張に対応
            // subscribable_type (例: 'App\\Models\\Market') + subscribable_id
            $table->morphs('subscribable', 'notif_subs_morph_index');

            // 'restock','price_drop','event_reminder' など何を通知してほしいか
            $table->string('notify_on');

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(
                ['user_id', 'subscribable_type', 'subscribable_id', 'notify_on'],
                'unique_subscription'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notif_subscriptions');
    }
};