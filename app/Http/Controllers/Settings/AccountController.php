<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\DestroyAccountRequest;
use App\Http\Requests\Settings\UpdateAccountRequest;
use App\Services\UserSettingsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function __construct(protected UserSettingsService $settingsService) {}

    public function index()
    {
        return redirect()->route('settings.account');
    }

    public function account()
    {
        return view('settings._account', [
            'user' => $this->settingsService->accountViewData(auth()->user()),
        ]);
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $user = auth()->user();
        $data = $request->safe()->only(['name', 'username', 'bio', 'email', 'password']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->fill($data);
        $user->save();

        return back()->with('success', 'アカウント情報を保存しました');
    }

    public function destroyAccount(DestroyAccountRequest $request)
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'アカウントを削除しました');
    }
}
