<button type="button"
        class="hs-sos-btn"
        data-bs-toggle="modal"
        data-bs-target="#emergencyModal"
        aria-label="{{ __('healthcare.emergency.sos_label') }}">
    <i class="fa-solid fa-phone-flip hs-sos-btn__icon"></i>
    <span class="hs-sos-btn__label">SOS</span>
</button>

@push('modals')
<div class="modal fade"
     id="emergencyModal"
     tabindex="-1"
     aria-labelledby="emergencyModalTitle"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered hs-emergency-dialog">
        <div class="modal-content hs-emergency-modal">

            <div class="modal-header hs-emergency-modal__header">
                <h5 class="hs-emergency-modal__title" id="emergencyModalTitle">
                    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                    {{ __('healthcare.emergency.modal_title') }}
                </h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="{{ __('healthcare.emergency.close') }}">
                </button>
            </div>

            <div class="modal-body hs-emergency-modal__body">

                <div class="hs-emergency-modal__section hs-emergency-modal__section--primary">
                    <a href="tel:911"
                       class="hs-emergency-modal__primary-btn">
                        <span class="hs-emergency-modal__primary-icon" aria-hidden="true">
                            <i class="fa-solid fa-truck-medical"></i>
                        </span>
                        <span class="hs-emergency-modal__primary-label">
                            {{ __('healthcare.emergency.call_911') }}
                        </span>
                    </a>

                    <a href="#hs-emergency-phrases"
                       class="hs-emergency-modal__phrases-link">
                        {{ __('healthcare.emergency.phrases_link') }}
                    </a>
                </div>

                <div class="hs-emergency-modal__section">
                    <p class="hs-emergency-modal__section-label">
                        {{ __('healthcare.emergency.other_contacts') }}
                    </p>

                    <div class="hs-emergency-modal__contacts">
                        <a href="tel:+63324799047"
                           class="hs-emergency-modal__contact-btn hs-emergency-modal__contact-btn--school">
                            <span>{{ __('healthcare.emergency.school_hotline') }}</span>
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        </a>
                        <a href="tel:09175717436"
                           class="hs-emergency-modal__contact-btn hs-emergency-modal__contact-btn--jhd">
                            <span>{{ __('healthcare.emergency.cebu_doc_jhd') }}</span>
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        </a>
                        <a href="tel:09177912177"
                           class="hs-emergency-modal__contact-btn hs-emergency-modal__contact-btn--jhd">
                            <span>{{ __('healthcare.emergency.chong_hua_jhd') }}</span>
                            <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <button type="button"
                        class="hs-emergency-modal__close-btn"
                        data-bs-dismiss="modal">
                    {{ __('healthcare.emergency.close') }}
                </button>

            </div>
        </div>
    </div>
</div>
@endpush
