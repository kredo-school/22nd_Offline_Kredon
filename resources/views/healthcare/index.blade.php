@extends('layouts.app')

@section('title', 'Hospital')

@section('content')

<div class="container py-4 mt4 hs-page">
    <div class="row g-4">

        {{-- メインエリア --}}
        <div class="col-12 col-md-8">
            {{-- Hero --}}
            <div class="mb-4 hs-section">
                @include('healthcare.partials._hero')
            </div>

            {{-- 医務室 --}}
            <div class="mb-4 hs-section">
                @include('healthcare.partials._medical_office')
            </div>

            {{-- アクションボタン --}}
            <div class="mb-4 hs-section">
                @include('healthcare.partials._action')
            </div>

            {{-- ウィザード --}}
            <div id="search-section" class="mb-4 hs-section hs-wizard-section">

                <p class="hs-section-band">
                    {{ __('healthcare.action.find_hospital') }}
                </p>

                @if($wizardStep)
                    @include('healthcare.wizard._wizard_card', [
                        'step' => $wizardStep['step'],
                        'totalSteps' => $wizardStep['totalSteps'],
                        'question' => $wizardStep['question'],
                        'options' => $wizardStep['options'],
                        'infoOptions' => $wizardStep['infoOptions'] ?? [],
                        'selectedAnswer' => $selectedAnswer,
                        'embedded' => true,
                    ])
                @endif
            </div>

            @if(($wizardComplete ?? false) && !request()->boolean('from_result'))
                @include('healthcare.wizard._wizard_result', [
                    'hospital' => $wizardHospital,
                    'reasons' => $wizardReasons ?? [],
                ])
            @endif

            {{--  病院一覧 --}}
            <div class="mb-4 hs-section">
                @include('healthcare.partials._card')
            </div>

        </div>

        {{-- サイドバー --}}
        <div class="col-12 col-md-4">
            <div class="sticky-top" style="top: 20px;">
                @include('healthcare.partials._faq', ['faqCategories' => $faqCategories])
            </div>
        </div>

        {{-- 注意 --}}
        <div class="col-12 mb-4 hs-section">
            @include('healthcare.partials._notes')
        </div>

    </div>
</div>

{{-- SOSボタン --}}
@include('healthcare.partials._emergency')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const scroller = document.querySelector('.content-body');
        const emergencyModal = document.getElementById('emergencyModal');

        const scrollToHash = (hash) => {
            if (!hash || !scroller) {
                return;
            }

            const target = document.querySelector(hash);

            if (!target) {
                return;
            }

            const top = target.getBoundingClientRect().top
                - scroller.getBoundingClientRect().top
                + scroller.scrollTop
                - 16;

            scroller.scrollTo({ top: Math.max(top, 0), behavior: 'smooth' });
        };

        const showCollapse = (element) => {
            if (!element || element.classList.contains('show')) {
                return Promise.resolve();
            }

            const instance = bootstrap.Collapse.getOrCreateInstance(element, { toggle: false });

            return new Promise((resolve) => {
                element.addEventListener('shown.bs.collapse', resolve, { once: true });
                instance.show();
            });
        };

        const openEmergencyPhrasesAndScroll = () => {
            const anchor = document.getElementById('hs-emergency-phrases');

            if (!anchor) {
                return;
            }

            const categoryEl = document.querySelector(anchor.dataset.hsCategoryCollapse || '');
            const faqEl = document.querySelector(anchor.dataset.hsFaqCollapse || '');

            showCollapse(categoryEl)
                .then(() => showCollapse(faqEl))
                .then(() => {
                    scrollToHash('#hs-emergency-phrases');
                    history.replaceState(null, '', '#hs-emergency-phrases');
                });
        };

        document.querySelector('.hs-emergency-modal__phrases-link')?.addEventListener('click', (event) => {
            event.preventDefault();

            if (!emergencyModal) {
                openEmergencyPhrasesAndScroll();
                return;
            }

            const modalInstance = bootstrap.Modal.getInstance(emergencyModal)
                || bootstrap.Modal.getOrCreateInstance(emergencyModal);

            emergencyModal.addEventListener('hidden.bs.modal', openEmergencyPhrasesAndScroll, { once: true });
            modalInstance.hide();
        });

        if (window.location.hash) {
            if (window.location.hash === '#hs-emergency-phrases') {
                openEmergencyPhrasesAndScroll();
            } else if (window.location.hash !== '#wizard-result') {
                scrollToHash(window.location.hash);
            }
        }

        document.addEventListener('click', (event) => {
            const link = event.target.closest('a[href^="#"]');

            if (!link) {
                return;
            }

            if (link.classList.contains('hs-emergency-modal__phrases-link')) {
                return;
            }

            const hash = link.getAttribute('href');

            if (!hash || hash === '#' || !document.querySelector(hash)) {
                return;
            }

            if (link.hasAttribute('data-bs-toggle')) {
                return;
            }

            event.preventDefault();
            scrollToHash(hash);
            history.replaceState(null, '', hash);
        });
    });
</script>
@endpush
