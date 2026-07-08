@extends('settings.index')

@section('settings-content')

<div class="st-page">
    <div class="st-page__main">

        <a href="{{ route('settings.account') }}" class="st-guide__back">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to Account Settings
        </a>

        <section class="st-card st-card--account" aria-labelledby="two-factor-heading">
            <div class="st-card__head">
                <h2 id="two-factor-heading" class="st-card__heading">Two-Factor Authentication (2FA) Setup</h2>
                <p class="st-card__lead">
                    Scan the QR code with an authenticator app (such as Google Authenticator),
                    or enter the secret key manually.
                </p>
            </div>

            <div class="st-2fa-setup">
                <div class="st-2fa-setup__qr">
                    <div class="st-2fa-setup__qr-inner">
                        {!! $qrCodeSvg !!}
                    </div>
                </div>

                <div class="st-2fa-setup__panel">
                    <div class="st-2fa-setup__secret">
                        <p class="st-2fa-setup__secret-label">Manual entry secret key</p>
                        <p class="st-2fa-setup__secret-value">{{ trim(chunk_split($secret, 4, ' ')) }}</p>
                    </div>

                    <form action="{{ route('settings.two-factor.confirm') }}" method="POST" class="st-2fa-setup__form">
                        @csrf

                        <label for="code" class="st-form-label">6-digit code from authenticator app</label>
                        <input type="text"
                               id="code"
                               name="code"
                               class="st-input st-2fa-setup__code"
                               placeholder="000000"
                               inputmode="numeric"
                               pattern="[0-9]{6}"
                               maxlength="6"
                               autocomplete="one-time-code"
                               required>

                        @error('code')
                            <p class="st-form-error" role="alert">{{ $message }}</p>
                        @enderror

                        <div class="st-form-actions">
                            <button type="submit" class="st-btn st-btn--primary">Enable</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
