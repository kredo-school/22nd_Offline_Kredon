<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notif_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_id')
                ->constrained('notif_templates')
                ->cascadeOnDelete();

            // 'manual'(都度手動送信) / 'auto'(イベント駆動) / 'recurring'(定期配信)
            $table->enum('delivery_mode', ['manual', 'auto', 'recurring'])->default('manual');

            // delivery_mode = 'auto' の時のみ使用。例: 'comment.created'
            $table->string('trigger_event')->nullable();

            // delivery_mode = 'recurring' の時のみ使用。'daily' / 'weekly' / 'monthly'
            $table->string('recurrence_rule')->nullable();

            // 'monday' など。recurrence_rule = 'weekly' の時のみ使用
            $table->string('recurrence_day_of_week')->nullable();

            // 配信時刻。例: '09:00:00'
            $table->time('recurrence_time')->nullable();

            // バッチが「次にいつ送るべきか」を判定するための日時
            $table->timestamp('next_run_at')->nullable();

            // 対象者の絞り込み(配信設定単位で上書き可能)
            $table->string('target_type')->default('all');

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['delivery_mode', 'is_active']);
            $table->index('next_run_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notif_schedules');
    }
};