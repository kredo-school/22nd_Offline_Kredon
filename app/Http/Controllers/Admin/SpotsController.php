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

    public function updateStatus(Request $request, string $type, int $id)
    {
        $request->validate([
            'status' => 'required|in:published,draft,unpublished',
        ]);

        $model = match ($type) {
            'working' => Spot::findOrFail($id),
            'tourism' => TouristSpot::findOrFail($id),
            default   => abort(404),
        };

        $model->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status'  => $model->status,
        ]);
    }
}