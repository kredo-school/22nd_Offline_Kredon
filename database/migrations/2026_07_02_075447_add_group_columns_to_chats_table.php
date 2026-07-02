<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chats', function (Blueprint $table) {

            $table->string('type')
                  ->default('private')
                  ->after('id');

            $table->foreignId('event_id')
                  ->nullable()
                  ->after('type')
                  ->constrained()
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {

            $table->dropConstrainedForeignId('event_id');
            $table->dropColumn('type');

        });
    }
};