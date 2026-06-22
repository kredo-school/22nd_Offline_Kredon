<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // 元になったテンプレート (緊急手動送信などtemplateなしの場合もあるためnullable)
            $table->foreignId('template_id')
                ->nullable()
                ->constrained('notif_templates')
                ->nullOnDelete();

            // 受信者
            $table->foreignId('recipient_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            // 配信対象：all/ member(premium)/ custom
                $table->string('target_type')->default('custom');

            // template由来のカテゴリをコピー (フィルタ高速化のための非正規化)
            $table->string('category');

            // 変数展開済みの実際の文面
            $table->string('title');
            $table->text('body');

            // 通知クリック時の遷移先情報など: {"post_id":1,"comment_id":5,"url":"/reviews/1"}
            $table->json('data')->nullable();


            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            // 予約送信時刻。即時通知ならnull
            $table->timestamp('scheduled_at')->nullable();

            // 実際に送信(配信)された時刻
            $table->timestamp('sent_at')->nullable();

            // 'pending','sent','failed'
            $table->string('status')->default('pending');

            $table->timestamps();

            // よく使う検索パターンにインデックス
            $table->index(['recipient_id', 'is_read']);
            $table->index(['category', 'sent_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};