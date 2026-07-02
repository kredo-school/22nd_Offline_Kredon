<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookmarkController extends Controller
{
    public function store(Request $request, Hospital $hospital)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'ログインが必要です'], 401);
        }

        $existing = $hospital->bookmarks()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
            Log::info('ブックマーク解除:', ['hospital_id' => $hospital->id, 'user_id' => $user->id]);

            return response()->json(['message' => '解除完了', 'bookmarked' => false]);
        }

        $hospital->bookmarks()->create(['user_id' => $user->id]);
        Log::info('ブックマーク登録:', ['hospital_id' => $hospital->id, 'user_id' => $user->id]);

        return response()->json(['message' => '登録完了', 'bookmarked' => true]);
    }

    public function destroy(Hospital $hospital)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'ログインが必要です'], 401);
        }

        $hospital->bookmarks()->where('user_id', $user->id)->delete();
        Log::info('ブックマーク削除:', ['hospital_id' => $hospital->id, 'user_id' => $user->id]);

        return response()->json(['message' => '解除完了', 'bookmarked' => false]);
    }
}
