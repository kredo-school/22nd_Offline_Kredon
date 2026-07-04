<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('hospital_images') || !Schema::hasTable('images')) {
            return;
        }

        if (DB::table('hospital_images')->exists()) {
            return;
        }

        if (!Schema::hasColumn('images', 'imageable_type')) {
            return;
        }

        $rows = DB::table('images')
            ->where('imageable_type', 'App\Models\Hospital')
            ->orderBy('id')
            ->get();

        foreach ($rows as $row) {
            DB::table('hospital_images')->insert([
                'hospital_id' => $row->imageable_id,
                'user_id' => $row->user_id,
                'url' => $row->url,
                'caption' => $row->caption,
                'sort_order' => $row->sort_order ?? 0,
                'created_at' => $row->created_at,
            ]);
        }

        if (!Schema::hasTable('hospital_bookmarks') || !Schema::hasTable('bookmarks')) {
            return;
        }

        if (DB::table('hospital_bookmarks')->exists()) {
            return;
        }

        if (!Schema::hasColumn('bookmarks', 'bookmarkable_type')) {
            return;
        }

        $bookmarks = DB::table('bookmarks')
            ->where('bookmarkable_type', 'App\Models\Hospital')
            ->orderBy('id')
            ->get();

        foreach ($bookmarks as $row) {
            DB::table('hospital_bookmarks')->insert([
                'user_id' => $row->user_id,
                'hospital_id' => $row->bookmarkable_id,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        //
    }
};
