<?php

namespace App\Http\Controllers;

class SettingController extends Controller
{
    public function index()
    {
        return redirect()->route('settings.account');
    }
}
