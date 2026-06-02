<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location_name');
            $table->text('description');
            $table->string('category');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_posts');
    }
};