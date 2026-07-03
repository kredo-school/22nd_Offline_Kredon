<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UpdateDisplayRequest;
use App\Models\CharacterTemp;
use App\Services\UserSettingsService;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function __construct(protected UserSettingsService $settingsService) {}

    public function display()
    {
        $user = auth()->user();

        return view('settings._display', [
            'user'    => $this->settingsService->accountViewData($user),
            'display' => $this->settingsService->displaySettings($user),
        ]);
    }

    public function updateDisplay(UpdateDisplayRequest $request)
    {
        $user     = auth()->user();
        $settings = $this->settingsService->ensureSettings($user);
        $character = CharacterTemp::query()->where('slug', $request->validated('character_id'))->firstOrFail();

        $settings->update([
            'color_mode'        => $request->validated('color_mode'),
            'character_temp_id' => $character->id,
        ]);

        return back()->with('success', '表示設定を保存しました');
    }
}
