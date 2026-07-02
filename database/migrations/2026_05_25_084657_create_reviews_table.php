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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // 💡 超重要：どこのお店に対するレビューなのかを記録する（spotsテーブルのidと合体！）
            $table->foreignId('spot_id')->constrained()->onDelete('cascade');
            
            // 💡 超重要2：誰が書いたレビューなのかを記録する（usersテーブルのidと合体！）
            // これがあるから、レビューを書いたユーザーを特定して「レベルアップ」させる処理が作れます！
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 🌟 Taka-sanこだわり：死角度（★1〜5を想定して整数 integer で作ります）
            $table->integer('dead_spot_rating')->default(3);

            // 🌟 エアコンの寒さレベル（★1〜5）
            $table->integer('aircon_level')->default(3);

            // 🌟 滞在目安時間レベル（★1〜5）
            $table->integer('stay_time_level')->default(3);

            // コメントも一言残せるようにしておくと、より生々しい一次情報になります！
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
