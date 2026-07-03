<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function setup(Request $request)
    {
        $user   = auth()->user();
        $secret = session('2fa_secret');

        if (! $secret) {
            $google2fa = new Google2FA();
            $secret    = $google2fa->generateSecretKey();
            session(['2fa_secret' => $secret]);
        }

        $google2fa = new Google2FA();
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
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
        $valid     = $google2fa->verifyKey($secret, $request->code);

        if (! $valid) {
            return back()->withErrors(['code' => '認証コードが正しくありません']);
        }

        auth()->user()->update([
            'two_factor_secret'   => $secret,
            'two_factor_enabled'  => true,
        ]);

        session()->forget('2fa_secret');

        return redirect()->route('settings.account')->with('success', '2段階認証を有効にしました');
    }

    public function disable(Request $request)
    {
        auth()->user()->update([
            'two_factor_secret'  => null,
            'two_factor_enabled' => false,
        ]);

        return back()->with('success', '2段階認証を無効にしました');
    }
}
