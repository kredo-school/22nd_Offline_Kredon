<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('spot_edit_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spot_id')->constrained()->onDelete('cascade'); // どのスポットか
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 誰が編集したか
            $table->timestamps(); // いつ編集したか（created_atに自動で入る）
        });
    }

    public function down()
    {
        Schema::dropIfExists('spot_edit_histories');
    }
};