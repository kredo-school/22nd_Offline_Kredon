@extends('layouts.app') 

@section('title', 'Home') 

@section('content') 

<div class="custom-container">
    <div class="custom-layout">

        {{-- メインエリア --}}
        <main class="main-column">
                @include('home.partials._hero')
            </div>
                @include('home.partials._action')
            </div>
                @include('home.partials._feed')
            </div>
        </main>

        {{-- 右カラム --}}
        <aside class="side-column">
            @include('home.partials._right_card')
        </aside>
    </div>
</div>
@endsection