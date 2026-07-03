@extends('layouts.app')

@section('title', '病院管理一覧')

@section('content')
<div class="container py-5">
    <div class="hs-header-group d-flex justify-content-between align-items-center mb-4">
        <h2 class="hs-title">病院一覧管理</h2>
        <a href="{{ route('admin.hospitals.create') }}" class="btn btn-primary hs-btn-primary">新規登録</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success hs-alert">{{ session('success') }}</div>
    @endif

    <div class="card hs-card shadow-sm">
        <div class="card-body hs-card-body">
            <table class="table hs-table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>病院名</th>
                        <th>登録画像</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hospitals as $hospital)
                    <tr>
                        <td>{{ $hospital->id }}</td>
                        <td>{{ $hospital->name }}</td>
                        <td>
                            @if($hospital->images->isNotEmpty())
                                <img src="{{ $hospital->images->first()->display_url }}" 
                                     alt="病院画像" style="width: 100px; height: 60px; object-fit: cover;">
                            @else
                                <span class="text-muted small">画像なし</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" class="btn btn-sm btn-outline-info hs-btn-edit">編集</a>
                            <form action="#" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger hs-btn-delete" 
                                        onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection