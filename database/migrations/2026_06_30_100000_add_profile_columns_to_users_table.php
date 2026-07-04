<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('name');
            }

            if (! Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('username');
            }

            // avatar は 2026_05_28_071424_add_avater_to_users_table で追加済み
            if (! Schema::hasColumn('users', 'two_factor_enabled')) {
                $table->boolean('two_factor_enabled')->default(false)->after('avatar');
            }

            if (! Schema::hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable()->after('two_factor_enabled');
            }

            if (! Schema::hasColumn('users', 'posts_count')) {
                $table->unsignedInteger('posts_count')->default(0)->after('two_factor_secret');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'bio',
                'two_factor_enabled',
                'two_factor_secret',
                'posts_count',
            ]);
        });
    }
};
