<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Http\Requests\StoreHospitalImageRequest;

class HospitalImageController extends Controller
{
    public function store(StoreHospitalImageRequest $request, $hospitalId)
    {
        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/hospitals'), $fileName);
        $path = 'hospitals/' . $fileName;

        $hospital = Hospital::findOrFail($hospitalId);

        $hospital->images()->create([
            'user_id' => auth()->id(),
            'url' => $path,
            'sort_order' => 0,
            'created_at' => now(),
        ]);

        return back()->with('success', '画像が保存されました!');
    }
}
