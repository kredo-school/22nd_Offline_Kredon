@extends('layouts.app') 

@section('title', 'Home') 

@section('content') 
<div class="container-fluid py-4"> 
    <div class="row g-3 align-items-stretch mt-5"> 
        {{-- メインエリア (col-lg-8) --}} 
        <div class="col-lg-8 d-flex flex-column"> 
            <div class="mb-4"> 
                @include('home.partials._hero') 
            </div> 
            <div class="mb-4"> 
                @include('home.partials._action') 
            </div>
            <div class="mb-4">
                @include('home.partials._feed')
            </div>
           
        </div> 

        {{-- 右カラム (col-lg-4) --}} 
        <div class="col-lg-4"> 
            @include('home.partials._right_card') 
        </div> 
    </div> 
</div> 
@endsection

