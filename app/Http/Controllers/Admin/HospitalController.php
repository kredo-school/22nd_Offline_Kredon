<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalTest; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = HospitalTest::with('images')->latest()->get();
        return view('admin.hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('admin.hospitals.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'image' => 'nullable|image']);
        
        $hospital = HospitalTest::create(['name' => $request->name]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hospital', 'public');
            $hospital->images()->create(['image_path' => $path]);
        }

        return redirect()->route('admin.hospitals.index')->with('success', '登録しました！');
    }

    public function edit($id)
    {
        $hospital = HospitalTest::findOrFail($id);
        return view('admin.hospitals.edit', compact('hospital'));
    }

    // ここが正しく update メソッドになっています
    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'image' => 'nullable|image']);
        
        $hospital = HospitalTest::findOrFail($id);
        $hospital->update(['name' => $request->name]);

        if ($request->hasFile('image')) {
            // 古い画像を削除
            foreach ($hospital->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            // 新しい画像を保存
            $path = $request->file('image')->store('hospital', 'public');
            $hospital->images()->create(['image_path' => $path]);
        }

        return redirect()->route('admin.hospitals.index')->with('success', '更新しました！');
    }

    public function destroy($id)
    {
        $hospital = HospitalTest::findOrFail($id);
        foreach ($hospital->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $hospital->delete();
        return redirect()->route('admin.hospitals.index')->with('success', '削除しました');
    }
}