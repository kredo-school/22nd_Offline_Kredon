<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
          $table->id();

$table->foreignId('user_id')
      ->constrained()
      ->cascadeOnDelete();

$table->string('title');
$table->string('category')->nullable();
$table->text('description')->nullable();
$table->string('location')->nullable();
$table->date('event_date')->nullable();

$table->string('image1')->nullable();
$table->string('image2')->nullable();

$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};