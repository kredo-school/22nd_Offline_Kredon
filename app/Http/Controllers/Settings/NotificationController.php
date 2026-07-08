<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateNotificationRequest;
use App\Services\UserSettingsService;

class NotificationController extends Controller
{
    public function __construct(protected UserSettingsService $settingsService) {}

    public function notification()
    {
        $user = auth()->user();

        return view('settings._notification', [
            'user'         => $this->settingsService->accountViewData($user),
            'notification' => $this->settingsService->notificationSettings($user),
        ]);
    }

    public function updateNotification(UpdateNotificationRequest $request)
    {
        $user     = auth()->user();
        $settings = $this->settingsService->ensureSettings($user);

        $settings->update([
            'notification_settings' => $this->settingsService->mergeNotificationSettings($request->all()),
        ]);

        return back()->with('success', 'Notification settings saved');
    }

    public function resetNotification()
    {
        $this->settingsService->resetNotificationSettings(auth()->user());

        return back()->with('success', 'Notification settings reset to defaults');
    }
}
