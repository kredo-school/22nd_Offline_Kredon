@extends('game.layout')

@section('title', 'Battle Result')

@section('content')

<style>

html,
body{
    margin:0;
    width:100%;
    height:100%;
    overflow:hidden;
}

.result-container{
    position:relative;
    width:100vw;
    height:100vh;
}

/* 背景画像を全画面 */

#resultImage{
    position:absolute;
    inset:0;

    width:100%;
    height:100%;

    object-fit:fill;

    display:block;
}

/* VICTORY / DEFEAT */

#statusText{

    position:absolute;

    top:20%;
    left:50%;

    transform:translateX(-50%);

    font-size:60px;
    font-weight:bold;

    color:white;

    text-shadow:
        3px 3px 10px black;

    z-index:100;
}

/* HOMEボタン */

.btn-home{

    position:absolute;

    left:50%;
    bottom:40%;

    transform:translateX(-50%);

    padding:18px 40px;

    background:rgba(205, 11, 82, 0.8);

    color:white;

    text-decoration:none;

    border-radius:15px;

    font-size:28px;

    font-weight:bold;

    z-index:100;
}

.btn-home:hover{
    background:rgba(255,255,255,.2);
}

</style>

<div class="result-container">

    <h1 id="statusText"></h1>

    <img
        id="resultImage"
        src=""
        alt="result">

    <a
        href="{{ route('game.select') }}"
        class="btn-home">

        HOME

    </a>

</div>

<script>

const urlParams =
new URLSearchParams(window.location.search);

const status =
urlParams.get('status');

const resultImage =
document.getElementById('resultImage');

const statusText =
document.getElementById('statusText');

if(status === 'win'){

    statusText.innerHTML = '';

    resultImage.src =
    "{{ asset('images/victory.png') }}";

}else{

    statusText.innerHTML = 'Better luck next time';

    resultImage.src =
    "{{ asset('images/defeat.png') }}";
}

</script>

@endsection