<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;

class StudyController extends Controller
{
    public function index(Request $request)
    {
        $query = Spot::query();

        if ($request->filled('wifi')) {
            $query->where('has_wifi', 1);
        }

        if ($request->filled('power')) {
            $query->where('has_power', 1);
        }

        if ($request->filled('area')) {
            $query->where('area', $request->input('area'));
        }
        // 💡 with(['reviews']) を挟むことで、繋げた電線からレビューデータも一撃で全件一緒に持ってきます！
        $spots = $query->with(['reviews'])->get();

        return view('welcome', compact('spots'));
    }
}
