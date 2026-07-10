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
                        'subtitle' => $wizardStep['subtitle'] ?? null,
                        'options' => $wizardStep['options'],
                        'infoOptions' => $wizardStep['infoOptions'] ?? [],
                        'selectedAnswer' => $selectedAnswer,
                    ])
                @endif
            </div>

            @if(($wizardComplete ?? false) && !request()->boolean('from_result'))
                @include('healthcare.wizard._wizard_result', [
                    'resultItems' => $wizardResultItems ?? [],
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
