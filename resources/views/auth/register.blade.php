@extends('layouts.app')

@php

$characters = [

[
'image'=>'register1.png',
'name'=>'KUREJINA',
'quote'=>'Welcome to Cebu! Let’s enjoy this adventure together!'
],

[
'image'=>'register2.png',
'name'=>'MENIDON',
'quote'=>'Every great journey begins with one brave step.'
],

[
'image'=>'register3.png',
'name'=>'KUREDON',
'quote'=>'Help your friends and build an amazing community!'
],

[
'image'=>'register4.png',
'name'=>'KUREDOG',
'quote'=>'Never stop learning. Your future starts today!'
],

[
'image'=>'register5.png',
'name'=>'KREMITI',
'quote'=>'Ready for your next quest? Let’s begin!'
],

];

$character = $characters[array_rand($characters)];

@endphp

<style>
html,
body{
    height:100%;
    overflow:hidden;
    margin:0;
    padding:0;
}

.container-fluid{
    height:100vh;
    overflow:hidden;
}
</style>

@section('content')

<div class="container-fluid vh-100 p-0">

<div class="position-relative w-100 h-100">

    {{-- ランダム背景画像 --}}
    <img src="{{ asset('images/'.$character['image']) }}"
         class="w-100 h-100"
         style="object-fit:contain;">

    {{-- フォーム --}}
    <div style="
        position:absolute;
        top:40%;
        right:18%;
        transform:translateY(-35%);
        width:340px;
    ">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">

                <input type="text"
                       name="name"
                       class="form-control form-control-lg"
                       placeholder="Name"
                       required>

            </div>

            <div class="mb-3">

                <input type="email"
                       name="email"
                       class="form-control form-control-lg"
                       placeholder="Email"
                       required>

            </div>

            <div class="mb-3">

                <input type="password"
                       name="password"
                       class="form-control form-control-lg"
                       placeholder="Password"
                       required>

            </div>

            <div class="mb-4">

                <input type="password"
                       name="password_confirmation"
                       class="form-control form-control-lg"
                       placeholder="Confirm Password"
                       required>

            </div>

            <button
                class="btn btn-success btn-lg w-100 fw-bold">

                Register

            </button>

        </form>

    </div>

</div>

</div>

@endsection