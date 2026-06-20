<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Support\Dummy\SettingDummyData;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    protected $user;

    public function __construct()
    {
        // 本番環境になったらここを差し替える
        // $this->user = auth()->user();

        $this->user = SettingDummyData::user();
    }

    public function setup(Request $request)
    {
        $secret = session('2fa_secret');

        if (! $secret) {
            $google2fa = new Google2FA();
            $secret = $google2fa->generateSecretKey();
            session(['2fa_secret' => $secret]);
        }

        $google2fa = new Google2FA();
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $this->user->email,   // ← auth()->user()ではなく$this->userを使う
            $secret
        );

        $qrCode = QrCode::create($qrCodeUrl);
        $writer = new SvgWriter();
        $result = $writer->write($qrCode);

        return view('settings.two-factor-setup', [
            'qrCodeSvg' => $result->getString(),
            'secret'    => $secret,
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $secret = session('2fa_secret');

        if (! $secret) {
            return back()->withErrors(['code' => 'セッションの有効期限が切れました。最初からやり直してください。']);
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->code);

        if (! $valid) {
            return back()->withErrors(['code' => '認証コードが正しくありません']);
        }

        // 本番ではここで実際にDBへ保存
        // auth()->user()->update([
        //     'google2fa_secret'   => encrypt($secret),
        //     'two_factor_enabled' => true,
        // ]);

        session()->forget('2fa_secret');

        return redirect()->route('settings._account')->with('success', '2段階認証を有効にしました');
    }

    public function disable(Request $request)
    {
        // 本番ではここで実際にDBを更新
        // auth()->user()->update([
        //     'google2fa_secret'   => null,
        //     'two_factor_enabled' => false,
        // ]);

        return back()->with('success', '2段階認証を無効にしました');
    }
}