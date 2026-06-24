@extends('layouts.app')

@section('title','KREDON Adventure')

@section('content')

<div class="game-screen">

    {{-- TOP BAR --}}
    <div class="top-bar">

        <div class="player-name">
            [K] AYUMU Lv.15
        </div>

        <div class="status">
            HP: 70/100
        </div>

        <div class="coins">
            🪙 500
        </div>

    </div>

    {{-- LOGO --}}
    <div class="game-logo">

        <h1>KREDON</h1>
        <span>ADVENTURE</span>

    </div>

    {{-- MISSION BOARD --}}
    <div class="mission-board">

        <div class="board-title">
            TODAY'S MISSIONS
        </div>

        <ul>
            <li>□ Complete 3 English Lessons</li>
            <li>□ Clear 2 IT Skill Stages</li>
            <li>□ Defeat 5 Enemies</li>
        </ul>

        <hr>

        <p>
            NEWS<br>
            New Event : IT Masters Challenge
        </p>

    </div>

    {{-- CHARACTER --}}
    <img
        src="{{ asset('images/kredon-pixel.png') }}"
        class="player-character">

    {{-- DOG --}}
    <img
        src="{{ asset('images/dog.png') }}"
        class="dog">

    {{-- HUT --}}
    <img
        src="{{ asset('images/hut.png') }}"
        class="hut">

    {{-- SIGN --}}
    <div class="adventure-sign">
        TO ADVENTURE!
    </div>

    {{-- BUTTONS --}}
    <div class="menu-buttons">

        <a href="#" class="btn-red">
            BEGIN ADVENTURE
        </a>

        <div class="row-buttons">

            <a href="#" class="btn-blue">
                UPGRADE<br>SKILLS
            </a>

            <a href="#" class="btn-yellow">
                LEARN<br>LANGUAGES
            </a>

        </div>

        <a href="#" class="btn-green">
            INVENTORY
        </a>

    </div>

</div>

@endsection