@extends('layouts.app')

@section('title', '病院情報編集')

@section('content')
<div class="container py-5">
    <div class="hs-header-group mb-4">
        <h2 class="hs-title">病院情報の編集</h2>
    </div>

    <div class="card hs-card shadow-sm">
        <div class="card-body hs-card-body">
            <form action="{{ route('admin.hospitals.update', $hospital->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')

                {{-- 病院名 --}}
                <div class="mb-3">
                    <label class="form-label">病院名</label>
                    <input type="text" name="name" class="form-control hs-form-control" value="{{ old('name', $hospital->name) }}" required>
                </div>

                {{-- 略称 --}}
                <div class="mb-3">
                    <label class="form-label">略称</label>
                    <input type="text" name="short_name" class="form-control hs-form-control" value="{{ old('short_name', $hospital->short_name) }}">
                </div>

                {{-- 画像編集エリア --}}
                <div class="mb-4">
                    <label class="form-label">病院画像</label>
                    
                    <div class="mb-2">
                        @if($hospital->images->isNotEmpty())
                            <div class="current-image-wrapper">
                                <p class="text-muted small">現在の画像:</p>
                                <img src="{{ asset('storage/' . $hospital->images->first()->image_path) }}" 
                                     alt="病院画像" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                        @else
                            <p class="text-muted">※現在画像は設定されていません</p>
                        @endif
                    </div>

                    <div class="mt-2">
                        <label class="form-label small text-primary">画像を変更する</label>
                        <input type="file" name="image" class="form-control hs-form-control">
                        <small class="text-muted">※新しい画像を選択すると、現在の画像は削除されます。</small>
                    </div>
                </div>

                {{-- ボタンエリア --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.hospitals.index') }}" class="btn btn-secondary">キャンセル</a>
                    <button type="submit" class="btn btn-primary hs-btn-primary">更新する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection