<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\Dummy\SettingDummyData;
class AccountController extends Controller
{
   protected $user;

    public function __construct()
    {
        // 本番環境になったらここを差し替える
        // $this->user = auth()->user();

        $this->user = SettingDummyData::user();
    }

    public function index()
    {
        return redirect()->route('settings.account');
    }

    public function account()
    {
        return view('settings._account', ['user' => $this->user]);
    }

}
