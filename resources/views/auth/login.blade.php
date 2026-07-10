@extends('layouts.app')

@php

$characters = [

[
'image'=>'register1.png',
'name'=>'KUREJINA',
'quote'=>'Welcome back!'
],

[
'image'=>'register2.png',
'name'=>'MENIDON',
'quote'=>'A new adventure awaits.'
],

[
'image'=>'register3.png',
'name'=>'KUREDON',

],

[
'image'=>'register4.png',
'name'=>'KUREDOG',
'quote'=>'Ready to continue learning?'
],

[
'image'=>'register5.png',
'name'=>'KREMITI',
'quote'=>'Your journey continues!'
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

    {{-- Background --}}
    <img src="{{ asset('images/'.$character['image']) }}"
         class="w-100 h-100"
         style="object-fit:contain;">

    {{-- Login Form --}}
    <div style="
        position:absolute;
        top:40%;
        right:18%;
        transform:translateY(-35%);
        width:340px;
    ">

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">

                <input id="email"
                       type="email"
                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Email"
                       required
                       autofocus>

                @error('email')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="mb-4">

                <input id="password"
                       type="password"
                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                       name="password"
                       placeholder="Password"
                       required>

                @error('password')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="form-check mb-3">

                <input class="form-check-input"
                       type="checkbox"
                       name="remember"
                       id="remember">

                <label class="form-check-label" for="remember">
                    Remember Me
                </label>

            </div>

            <button type="submit"
                    class="btn btn-success btn-lg w-100 fw-bold">

                Login

            </button>

            @if (Route::has('password.request'))

                <div class="text-center mt-3">

                    <a href="{{ route('password.request') }}"
                       class="text-decoration-none">

                        Forgot Password?

                    </a>

                </div>

            @endif

        </form>

    </div>

</div>

</div>

@endsection