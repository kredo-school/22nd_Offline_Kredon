@extends('layouts.app')

@section('title', 'Kredon Support')

@section('content')

<div class="container py-5 mt-5">
    <div class="row g-4">
        
        {{-- メインエリア --}}
        <div class="col-12 col-md-8">
            {{-- 1. Hero --}}
            <div class="mb-4">
                @include('healthcare.partials._hero')
            </div>

            {{-- 2. 言語選択 --}}
            <div class="mb-4">
                @include('healthcare.partials._language')
            </div>

            {{-- 3. アクションボタン --}}
            <div class="mb-4">
                @include('healthcare.partials._action')
            </div>

            {{-- 4. 注意 --}}
            <div class="mb-4">
                @include('healthcare.partials._notes')
            </div>

            {{-- 5. }}

            {{-- }}

            {{-- 5. 医務室 --}}
            {{-- <div class="mb-4">
                @include('healthcare.partials._nurse.office')
            </div> --}}
        </div>
        
        {{-- サイドバー --}}
        <div class="col-12 col-md-4">
            <div class="sticky-top" style="top: 20px;">
                @include('healthcare.partials._faq')
            </div>
        </div>

    </div>
</div>

{{-- SOSボタン --}}
@include('healthcare.partials._emergency')

@endsection