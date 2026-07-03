<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // nullable() をつけることで、ユーザーが一部の評価を飛ばしてもエラーにならないようにします
            $table->tinyInteger('customer_vibe')->nullable()->comment('客層');
            $table->tinyInteger('eye_fatigue_level')->nullable()->comment('目の疲れ度');
            $table->tinyInteger('desk_stability')->nullable()->comment('机の安定度');
            $table->tinyInteger('chair_comfort')->nullable()->comment('イスの座りやすさ');
        });
    }

    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'customer_vibe',
                'eye_fatigue_level',
                'desk_stability',
                'chair_comfort'
            ]);
        });
    }
};
