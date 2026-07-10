<?php

namespace App\Http\Controllers;

use App\Models\ItemPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestedController extends Controller
{
    public function toggle(ItemPost $item)
    {
        $user = Auth::user();

        if ($item->interestedUsers()->where('user_id', $user->id)->exists()) {

            $item->interestedUsers()->detach($user->id);

        } else {

            $item->interestedUsers()->attach($user->id);

        }

        return back();
    }
}