<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\Dummy\SettingDummyData;
class PrivacyController extends Controller
{
    protected $user;
    
    public function __construct()
    {
        // ユーザー情報を初期化
        $this->user = SettingDummyData::user();
    }

    public function privacy()
    {
        return view('settings._privacy', [
            'user'    => $this->user,
            'privacy' => SettingDummyData::privacySettings(),
        ]);
    }

    public function privacyGuide()
    {
        return view('settings._privacy_guide', [
            'user'  => $this->user,
            'guide' => SettingDummyData::privacyGuide(),
        ]);
    }

}
