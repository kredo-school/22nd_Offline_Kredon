@php
    $currentLocale = app()->getLocale();
@endphp

<div class="hs-language">
    <div class="row g-3 g-md-4 justify-content-center">
        <div class="col-6 col-md-4">
            <a href="{{ route('locale.switch', 'ja') }}"
               class="btn hs-language__btn w-100 {{ $currentLocale === 'ja' ? 'btn-success' : 'btn-outline-success' }}"
               @if($currentLocale === 'ja') aria-current="true" @endif>
                {{ __('healthcare.language.japanese') }}
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="{{ route('locale.switch', 'en') }}"
               class="btn hs-language__btn w-100 {{ $currentLocale === 'en' ? 'btn-success' : 'btn-outline-success' }}"
               @if($currentLocale === 'en') aria-current="true" @endif>
                {{ __('healthcare.language.english') }}
            </a>
        </div>
    </div>
</div>
