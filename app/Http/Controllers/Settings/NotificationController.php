<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\Dummy\SettingDummyData;
class NotificationController extends Controller
{
    protected $user;
    public function __construct()
    {
        // ユーザー情報を初期化
        $this->user = SettingDummyData::user();
    }

    public function notification()
    {
        return view('settings._notification', [
            'user'         => $this->user,
            'notification' => SettingDummyData::notificationSettings(),
        ]);
    }

}
