<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    // コンストラクタでの注入を綺麗さっぱりやめて、シンプルに

    public function index()
    {
        // $this->user-> ではなく、User:: を使って直接呼び出す
        // $all_users = User::withTrashed()->paginate(10);
        $all_users = User::paginate(10);
        return view('admin.users.index')->with('all_users', $all_users);
    }
}
