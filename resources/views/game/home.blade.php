@extends('game.layout')

@section('title','KREDON Adventure')

@section('content')

<style>

.game-screen{
    position:relative;
    width:100vw;
    height:100vh;
}

.game-screen img{
    width:100%;
    height:100%;
    object-fit:fill;
    display:block;
}

.btn-area{
    position:absolute;
    display:block;
    cursor:pointer;
}

.begin-btn{
    left:31%;
    top:56%;
    width:31%;
    height:10%;
}

.market-btn{
    left:31%;
    top:70%;
    width:15%;
    height:8%;
}

.chat-btn{
    left:47%;
    top:70%;
    width:15%;
    height:8%;
}

.inventory-btn{
    left:31%;
    top:82%;
    width:31%;
    height:8%;
}

.home-btn{
    position:absolute;
    top:20px;
    right:20px;

    background:#fff;
    color:#000;

    padding:12px 24px;
    border-radius:10px;

    text-decoration:none;
    font-weight:bold;

    z-index:999;
}

.btn-area:hover{
    background:rgba(255,255,255,.15);
}

</style>

<a href="{{ url('/home') }}"
class="home-btn">

HOME

</a>

<div class="game-screen">

<img
    src="{{ asset('images/kredon-game-home.png') }}"
    alt="KREDON Adventure">

<!-- BEGIN ADVENTURE -->
<a href="{{ route('game.select') }}"
   class="btn-area begin-btn">
</a>

<!-- MARKET -->
<a href="{{ route('marketplace.index') }}"
   class="btn-area market-btn">
</a>

<!-- CHAT -->
<a href="{{ route('chat.list') }}"
   class="btn-area chat-btn">
</a>

<!-- INVENTORY -->
<a href="{{ route('marketplace.index') }}"
   class="btn-area inventory-btn">
</a>

</div>

@endsection
