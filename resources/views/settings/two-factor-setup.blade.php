@extends('settings.index')

@section('settings-content')

<div class="st-page">
    <div class="st-page__main">

        <a href="{{ route('settings.account') }}" class="st-guide__back">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> アカウント設定に戻る
        </a>

        <section class="st-card st-card--account" aria-labelledby="two-factor-heading">
            <div class="st-card__head">
                <h2 id="two-factor-heading" class="st-card__heading">二段階認証 (2FA) の設定</h2>
                <p class="st-card__lead">
                    認証アプリ（Google Authenticator など）で QR コードを読み取るか、
                    シークレットキーを手入力してください。
                </p>
            </div>

            <div class="st-section-block">
                <div class="st-2fa-qr" style="text-align:center; margin-bottom:24px;">
                    {!! $qrCodeSvg !!}
                </div>

                <p class="st-setting-item__desc" style="margin-bottom:8px;">
                    手動入力用シークレットキー
                </p>
                <p class="st-setting-item__value" style="font-family:monospace; word-break:break-all;">
                    {{ $secret }}
                </p>
            </div>

            <form action="{{ route('settings.two-factor.confirm') }}" method="POST" class="st-section-block">
                @csrf

                <label for="code" class="st-form-label">認証アプリの6桁コード</label>
                <input type="text"
                       id="code"
                       name="code"
                       class="st-input"
                       inputmode="numeric"
                       pattern="[0-9]{6}"
                       maxlength="6"
                       autocomplete="one-time-code"
                       required>

                @error('code')
                    <p class="st-form-error" role="alert">{{ $message }}</p>
                @enderror

                <div class="st-form-actions" style="margin-top:16px;">
                    <button type="submit" class="st-btn st-btn--primary">有効化する</button>
                </div>
            </form>
        </section>
    </div>
</div>

@endsection
