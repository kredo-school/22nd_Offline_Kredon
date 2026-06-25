<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notif_templates', function (Blueprint $table) {
            $table->id();

            // 'system','comment','reply','event','item_alert','digest'
            $table->string('category');

            // テンプレート本文 (変数は {{commenter_name}} のような形式)
            $table->string('title');
            $table->text('body');

            // 通知の送り先: 'all','post_author','comment_author','subscriber','custom'
            $table->string('target_type')->default('custom');
            $table->boolean('is_active')->default(true);

            // 作成した管理者
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notif_templates');
    }
};