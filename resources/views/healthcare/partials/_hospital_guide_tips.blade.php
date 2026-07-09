@php
    $showGuideTips = (bool) $hospital->guideTips();
    $showJhdContact = $hospital->is_jhd_supported && $hospital->phone_number;
    $boxClass = $boxClass ?? 'mb-3 mt-3';
@endphp

@if($showGuideTips || $showJhdContact)
    <div class="alert alert-light border small hs-guide-tips {{ $boxClass }}">
        @if($showGuideTips)
            <p class="hs-guide-tips__text mb-0">{{ $hospital->guideTips() }}</p>
        @endif

        @if($showJhdContact)
            <div class="hs-guide-tips__contact {{ $showGuideTips ? 'hs-guide-tips__contact--spaced' : '' }}">
                <span class="hs-guide-tips__label">{{ __('healthcare.jhd.contact_label') }}</span>
                <a href="tel:{{ preg_replace('/\s+/', '', $hospital->phone_number) }}"
                   class="hs-guide-tips__phone">
                    <i class="fa-solid fa-phone me-1" aria-hidden="true"></i>{{ $hospital->phone_number }}
                </a>
            </div>
        @endif
    </div>
@endif
