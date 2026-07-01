<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Spot;
use App\Models\TouristSpot;
use Illuminate\Http\Request;

class SpotsController extends Controller
{
   public function index()
{
    $workingSpots = Spot::withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->latest()
        ->get();

    $tourismSpots = TouristSpot::withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->latest()
        ->get();

    return view('admin.spots.index', compact('workingSpots', 'tourismSpots'));
}
}
