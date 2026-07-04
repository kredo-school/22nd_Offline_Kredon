@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="hp-container">
    <div class="hp-layout">
        <main class="main-column">
            @include('home.partials._hero')
            @include('home.partials._action')
            @include('home.partials._filter')
            @include('home.partials._feed')
        </main>

        <aside class="side-column">
            @include('home.partials._right_card')
        </aside>
    </div>
</div>
@endsection
