<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdatePrivacyRequest;
use App\Services\UserSettingsService;

class PrivacyController extends Controller
{
    public function __construct(protected UserSettingsService $settingsService) {}

    public function privacy()
    {
        $user = auth()->user();

        return view('settings._privacy', [
            'user'    => $this->settingsService->accountViewData($user),
            'privacy' => $this->settingsService->privacySettings($user),
        ]);
    }

    public function privacyGuide()
    {
        return view('settings._privacy_guide', [
            'user'  => $this->settingsService->accountViewData(auth()->user()),
            'guide' => $this->settingsService->privacyGuide(),
        ]);
    }

    public function updatePrivacy(UpdatePrivacyRequest $request)
    {
        $user     = auth()->user();
        $settings = $this->settingsService->ensureSettings($user);

        $settings->update([
            'privacy_settings' => $this->settingsService->mergePrivacySettings($request->all()),
        ]);

        return back()->with('success', 'プライバシー設定を保存しました');
    }
}
