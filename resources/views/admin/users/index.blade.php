@extends('layouts.admin')
 
@section('title', 'Admin Users Index')
 
@section('content')

{{-- 仮 --}}
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users Management</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">All Users (Including Deleted)</h6>
        </div>
        <div class="card-body">
            <p>ここにユーザーの一覧テーブル（ID、名前、メールアドレス、ロールなど）をループ処理で表示</p>
            
            {{-- 仮のテーブル構造 --}}
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Test Admin</td>
                            <td>admin@example.com</td>
                            <td><span class="badge bg-danger">Admin</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection