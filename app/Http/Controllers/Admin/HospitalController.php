<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::with('images')->latest()->get();

        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('admin.hospitals.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'image' => 'nullable|image']);

        $hospital = Hospital::create(['name' => $request->name]);

        if ($request->hasFile('image')) {
            $path = $this->storeHospitalImage($request->file('image'));
            $hospital->images()->create([
                'user_id' => auth()->id(),
                'url' => $path,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('admin.hospitals.index')->with('success', '登録しました！');
    }

    public function edit($id)
    {
        $hospital = Hospital::findOrFail($id);

        return view('admin.hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'image' => 'nullable|image']);

        $hospital = Hospital::findOrFail($id);
        $hospital->update(['name' => $request->name]);

        if ($request->hasFile('image')) {
            foreach ($hospital->images as $image) {
                $this->deleteHospitalImage($image->url);
                $image->delete();
            }

            $path = $this->storeHospitalImage($request->file('image'));
            $hospital->images()->create([
                'user_id' => auth()->id(),
                'url' => $path,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('admin.hospitals.index')->with('success', '更新しました！');
    }

    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);

        foreach ($hospital->images as $image) {
            $this->deleteHospitalImage($image->url);
        }

        $hospital->delete();

        return redirect()->route('admin.hospitals.index')->with('success', '削除しました');
    }

    private function storeHospitalImage($file): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/hospitals'), $fileName);

        return 'hospitals/' . $fileName;
    }

    private function deleteHospitalImage(string $url): void
    {
        if (str_starts_with($url, 'hospitals/') || str_starts_with($url, 'hospital/')) {
            $path = public_path('images/' . $url);
            if (file_exists($path)) {
                unlink($path);
            }

            return;
        }

        Storage::disk('public')->delete($url);
    }
}
