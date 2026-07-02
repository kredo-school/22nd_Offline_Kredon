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

            {{-- wizard --}}
            {{-- <div class="mb-4">
                @include('healthcare.wizard._wizard_card')
            </div> --}}

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