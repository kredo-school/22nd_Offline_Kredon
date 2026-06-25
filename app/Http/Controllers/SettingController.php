<?php

namespace App\Http\Controllers;

use App\Support\Dummy\SettingDummyData;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = SettingDummyData::user();
    }

    public function index()
    {
        return redirect()->route('settings.account');
    }
}