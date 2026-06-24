@extends('game.layout')

@section('title','Stage 1-1 Battle')

@section('content')

<style>

html,body{
    width:100%;
    height:100%;
    margin:0;
    overflow:hidden;
}

.battle-screen{
    position:relative;
    width:100vw;
    height:100vh;
}

.battle-bg{
    position:absolute;
    inset:0;

    width:100%;
    height:100%;

    object-fit:fill;
}

/* PLAYER */

.player-box{
    position:absolute;

    top:20px;
    left:20px;

    width:220px;
    z-index:100;
}

/* ENEMY */

.enemy-box{
    position:absolute;

    top:20px;
    right:20px;

    width:220px;
    z-index:100;
}

.name{
    background:#222;
    color:white;

    padding:8px;

    text-align:center;
    font-weight:bold;

    border-radius:8px 8px 0 0;
}

.hp-bar{
    width:100%;
    height:24px;

    background:#444;
}

.hp{
    width:100%;
    height:100%;

    background:limegreen;
}

/* QUESTION */

.question{

    position:absolute;

    top:7%;
    left:22%;

    width:56%;
    height:10%;

    display:flex;
    align-items:center;
    justify-content:center;

    text-align:center;

    font-size:28px;
    font-weight:bold;

    z-index:100;
}

/* ANSWERS */

.answer{

    position:absolute;

    left:33%;

    width:42%;
    height:9%;

    background:transparent;

    border:none;

    cursor:pointer;

    font-size:22px;
    font-weight:bold;

    z-index:100;
}

.a{
    top:25%;
}

.b{
    top:39%;
}

.c{
    top:53%;
}

.d{
    top:67%;
}

.answer:hover{
    background:rgba(255,255,255,.15);
}

/* RESULT */

.result{

    position:absolute;

    bottom:4%;
    left:50%;

    transform:translateX(-50%);

    font-size:36px;
    font-weight:bold;

    color:white;

    z-index:100;
}

</style>

<div class="battle-screen">

<img src="{{ asset('images/battle-stage1.png') }}"
  class="battle-bg">

<!-- PLAYER -->

<div class="player-box">

```
<div class="name">
    KREDON Lv.1
</div>

<div class="hp-bar">
    <div id="playerHp" class="hp"></div>
</div>
```

</div>

<!-- ENEMY -->

<div class="enemy-box">

```
<div class="name">
    Cebu Monster
</div>

<div class="hp-bar">
    <div id="enemyHp" class="hp"></div>
</div>
```

</div>

<!-- QUESTION -->

<div id="question" class="question">
Loading...
</div>

<!-- ANSWERS -->

<button id="choiceA"
     class="answer a"
     onclick="answer(0)"> </button>

<button id="choiceB"
     class="answer b"
     onclick="answer(1)"> </button>

<button id="choiceC"
     class="answer c"
     onclick="answer(2)"> </button>

<button id="choiceD"
     class="answer d"
     onclick="answer(3)"> </button>

<div id="result" class="result"></div>

</div>

<script src="{{ asset('js/questions.js') }}"></script>

<script>

let playerHP = 100;
let enemyHP = 100;

let currentQuestion = 0;

loadQuestion();

function loadQuestion(){

    currentQuestion =
    Math.floor(Math.random() * questions.length);

    document.getElementById('question').innerHTML =
    questions[currentQuestion].question;

    document.getElementById('choiceA').innerHTML =
    questions[currentQuestion].choices[0];

    document.getElementById('choiceB').innerHTML =
    questions[currentQuestion].choices[1];

    document.getElementById('choiceC').innerHTML =
    questions[currentQuestion].choices[2];

    document.getElementById('choiceD').innerHTML =
    questions[currentQuestion].choices[3];
}

function answer(index){

    if(index === questions[currentQuestion].answer){

        enemyHP -= 25;

        if(enemyHP < 0){
            enemyHP = 0;
        }

        document.getElementById('enemyHp').style.width =
        enemyHP + '%';

        document.getElementById('result').innerHTML =
        'Correct!';

    }else{

        playerHP -= 20;

        if(playerHP < 0){
            playerHP = 0;
        }

        document.getElementById('playerHp').style.width =
        playerHP + '%';

        document.getElementById('result').innerHTML =
        'Wrong!';
    }

    if(enemyHP <= 0){

        alert('Stage Clear!');

        window.location.href =
        "{{ route('game.easy') }}";

        return;
    }

    if(playerHP <= 0){

        alert('Game Over');

        location.reload();

        return;
    }

    setTimeout(() => {

        loadQuestion();

        document.getElementById('result').innerHTML = '';

    },1000);
}

</script>

@endsection
