<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;


class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(){
        $all_users = $this->user->withTrashed()->paginate(10);
        return view('admin.users.index')->with('all_users', $all_users);

    }

    //  public function hide($id) {
    //     $this->post->destroy($id);
    //     return redirect()->back();
    // }

    // public function unhide($id) {
    //     $this->post->onlyTrashed()->findOrFail($id)->restore();
    //     return redirect()->back();
    // }
}

