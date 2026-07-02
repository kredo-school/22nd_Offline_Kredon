@php
    $currentLocale = app()->getLocale();
@endphp

<div class="row g-4 mt-4 justify-content-center">
    <div class="col-5 col-md-3">
        <a href="{{ route('locale.switch', 'ja') }}"
           class="btn w-100 py-3 fw-bold rounded-3 {{ $currentLocale === 'ja' ? 'btn-success' : 'btn-outline-success' }}"
           @if($currentLocale === 'ja') aria-current="true" @endif>
            {{ __('healthcare.language.japanese') }}
        </a>
    </div>

    <div class="col-5 col-md-3">
        <a href="{{ route('locale.switch', 'en') }}"
           class="btn w-100 py-3 fw-bold rounded-3 {{ $currentLocale === 'en' ? 'btn-success' : 'btn-outline-success' }}"
           @if($currentLocale === 'en') aria-current="true" @endif>
            {{ __('healthcare.language.english') }}
        </a>
    </div>
</div>
