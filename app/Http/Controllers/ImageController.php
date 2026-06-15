<?php

namespace App\Http\Controllers;

use App\Models\HospitalTest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreHospitalImageRequest;

class ImageController extends Controller
{
    public function store(StoreHospitalImageRequest $request, $hospitalId)
    {
        /** FormRequstによりコードが太るのを回避 **/

        $path = $request->file('image')->store('hospital', 'public');

        $hospital = HospitalTest::findOrFail($hospitalId);
        
        $hospital -> images()->create([
            'image_path' => $path,
        ]);

        return back()->with('success', '画像が保存されました!');
    }
}
