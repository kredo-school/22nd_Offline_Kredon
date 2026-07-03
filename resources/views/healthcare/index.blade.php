@extends('layouts.app')

@section('title', 'Hospital')

@section('content')

<div class="container py-5 mt-5">
    <div class="row g-4">
        
        {{-- メインエリア --}}
        <div class="col-12 col-md-8">
            {{-- Hero --}}
            <div class="mb-4">
                @include('healthcare.partials._hero')
            </div>

            {{-- 言語選択 --}}
            <div class="mb-4">
                @include('healthcare.partials._language')
            </div>

            {{-- アクションボタン --}}
            <div class="mb-4">
                @include('healthcare.partials._action')
            </div>

            {{-- 医務室 --}}
            <div class="mb-4">
                @include('healthcare.partials._medical_office')
            </div>

             {{-- 注意 --}}
            <div class="mb-4">
                @include('healthcare.partials._notes')
            </div>

            {{-- ウィザード --}}
            <div id="search-section" class="mb-4 hs-wizard-section">

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

            {{--  病院一覧 --}}
            <div class="mb-4">
                @include('healthcare.partials._card')
            </div>
            
        </div>
        
        {{-- サイドバー --}}
        <div class="col-12 col-md-4">
            <div class="sticky-top" style="top: 20px;">
                @include('healthcare.partials._faq', ['faqCategories' => $faqCategories])
            </div>
        </div>

    </div>
</div>

{{-- SOSボタン --}}
@include('healthcare.partials._emergency')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const hash = window.location.hash;
        const scroller = document.querySelector('.content-body');

        const scrollToHash = () => {
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

        scrollToHash();
    });
</script>
@endpush