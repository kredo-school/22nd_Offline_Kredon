<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->text('bio')->nullable()->after('username');
            $table->string('avatar')->nullable()->after('bio');
            $table->boolean('two_factor_enabled')->default(false)->after('avatar');
            $table->text('two_factor_secret')->nullable()->after('two_factor_enabled');
            $table->unsignedInteger('posts_count')->default(0)->after('two_factor_secret');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'bio',
                'avatar',
                'two_factor_enabled',
                'two_factor_secret',
                'posts_count',
            ]);
        });
    }
};
