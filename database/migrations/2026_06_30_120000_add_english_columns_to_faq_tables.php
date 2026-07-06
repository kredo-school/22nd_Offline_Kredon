<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->string('name_en')->nullable()->after('name');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->text('question_en')->nullable()->after('question');
            $table->text('answer_en')->nullable()->after('answer');
        });
    }

    public function down(): void
    {
        Schema::table('faq_categories', function (Blueprint $table) {
            $table->dropColumn('name_en');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['question_en', 'answer_en']);
        });
    }
};
