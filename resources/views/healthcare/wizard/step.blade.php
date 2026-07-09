@extends('layouts.app')

@section('title', __('healthcare.wizard.step_label', ['step' => $step]))

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-7">
            @include('healthcare.wizard._wizard_card', [
                'step' => $step,
                'totalSteps' => $totalSteps,
                'question' => $question,
                'subtitle' => $subtitle ?? null,
                'options' => $options,
                'infoOptions' => $infoOptions ?? [],
                'selectedAnswer' => $selectedAnswer ?? null,
            ])
        </div>
    </div>
</div>
@endsection
