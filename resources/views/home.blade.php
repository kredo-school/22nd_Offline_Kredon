@extends('layouts.app') 

@section('title', 'Home') 

@section('content') 

<div class="kk-container">
    <div class="kk-layout">

        {{-- メインエリア --}}
        <main class="main-column">
                @include('home.partials._hero')
                @include('home.partials._action')
                @include('home.partials._feed')
        </main>

        {{-- 右カラム --}}
        <aside class="side-column">
            @include('home.partials._right_card')
        </aside>
    </div>
</div>
@endsection