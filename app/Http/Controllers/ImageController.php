<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Http\Requests\StoreHospitalImageRequest;

class ImageController extends Controller
{
    public function store(StoreHospitalImageRequest $request, $hospitalId)
    {
        // 1. アップロードされたファイルを取得
        $file = $request->file('image');
    
        // 2. ファイル名を生成（現在の時刻 + 元のファイル名で重複を防ぐ）
        $fileName = time() . '_' . $file->getClientOriginalName();
    
        // 3. public/images/hospitals フォルダへ移動
        $file->move(public_path('images/hospitals'), $fileName);

        // 4. DBに保存するためのパス文字列（'hospitals/ファイル名'）を作成
        $path = 'hospitals/' . $fileName;

        // 5. 病院モデルを取得
        $hospital = Hospital::findOrFail($hospitalId);

        // 6. データベースへ保存
        $hospital->images()->create([
        'user_id' => auth()->id(),
        'url' => $path, // ここで先ほどの $path を使う
        'sort_order' => 0,
    ]);

        return back()->with('success', '画像が保存されました!');
    }
}
