<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\Dummy\SettingDummyData;
class CommentController extends Controller
{
    protected $user;

    public function __construct()
    {
        // ユーザー情報を初期化
        $this->user = SettingDummyData::user();
    }

     public function comment()
    {
        return view('settings._comment', [
            'user'    => $this->user,
            'comment' => SettingDummyData::commentSettings(),
        ]);
    }
}
