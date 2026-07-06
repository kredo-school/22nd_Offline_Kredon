@extends('layouts.app')

@section('title', '病院の新規登録')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- hs-card クラスでBootstrapのカードをラップ --}}
            <div class="card hs-card shadow-sm">
                <div class="card-header hs-card-header bg-primary text-white">病院の新規登録</div>
                <div class="card-body hs-card-body">
                    <form action="{{ route('admin.hospitals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label hs-form-label">病院名</label>
                            <input type="text" name="name" class="form-control hs-form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label hs-form-label">病院の画像</label>
                            <input type="file" name="image" class="form-control hs-form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-between hs-action-group">
                            <a href="{{ route('admin.hospitals.index') }}" class="btn btn-secondary hs-btn-secondary">戻る</a>
                            <button type="submit" class="btn btn-success hs-btn-success">登録する</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection