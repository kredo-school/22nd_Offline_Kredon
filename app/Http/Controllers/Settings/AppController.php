<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateAppRequest;
use App\Services\UserSettingsService;

class AppController extends Controller
{
    public function __construct(protected UserSettingsService $settingsService) {}

    public function app()
    {
        $user = auth()->user();

        return view('settings._app', [
            'user' => $this->settingsService->accountViewData($user),
            'app'  => $this->settingsService->appSettings($user),
        ]);
    }

    public function updateApp(UpdateAppRequest $request)
    {
        $user     = auth()->user();
        $settings = $this->settingsService->ensureSettings($user);

        $settings->update([
            'app_settings' => $this->settingsService->mergeAppSettings($request->all()),
        ]);

        return back()->with('success', 'App settings saved');
    }

    public function resetApp()
    {
        $this->settingsService->resetAppSettings(auth()->user());

        return back()->with('success', 'App settings reset to defaults');
    }
}
