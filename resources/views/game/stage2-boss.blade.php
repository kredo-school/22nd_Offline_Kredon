@extends('game.layout')

@section('title','Stage 1-1 Battle')

@section('content')

<style>
/* CSSは元のまま変更なし */
html,body{ width:100%; height:100%; margin:0; overflow:hidden; }
.battle-screen{ position:relative; width:100vw; height:100vh; }
.battle-bg{ position:absolute; inset:0; width:100%; height:100%; object-fit:fill; }
.player-box{ position:absolute; top:15px; left:15px; width:220px; z-index:10; }
.enemy-box{ position:absolute; top:15px; right:15px; width:220px; z-index:10; }
.name{ background:#222; color:#fff; padding:8px; text-align:center; font-weight:bold; }
.hp-bar{ width:100%; height:25px; background:#444; border:2px solid #fff; }
.hp{ height:100%; width:100%; background:limegreen; transition:.3s; }
.hp-text{ background:#111; color:white; text-align:center; padding:4px; }
.question{ position:absolute; top:7%; left:28%; width:44%; height:10%; display:flex; justify-content:center; align-items:center; text-align:center; font-size:34px; font-weight:bold; z-index:10; color:white; }
.answer{ position:absolute; left:30%; width:40%; height:8%; background:transparent; border:none; display:flex; justify-content:center; align-items:center; text-align:center; font-size:18px; font-weight:bold; cursor:pointer; z-index:10; color:white; }
.a{ top:33%; } .b{ top:50%; } .c{ top:66%; } .d{ top:83%; }
.answer:hover{ background:rgba(255,255,255,.15); border-radius:12px; }
.result{ position:absolute; bottom:5%; left:50%; transform:translateX(-50%); font-size:30px; font-weight:bold; color:white; z-index:10; }
</style>

<div class="battle-screen">
    <img src="{{ asset('images/battle-stage2-boss.png') }}" class="battle-bg">

    <div class="player-box">
        <div class="name">KUREMITI</div>
        <div class="hp-bar"><div id="playerHp" class="hp"></div></div>
        <div class="hp-text">HP : <span id="playerValue">100</span>/100</div>
    </div>

    <div class="enemy-box">
        <div class="name">Oily Food</div>
        <div class="hp-bar"><div id="enemyHp" class="hp"></div></div>
        <div class="hp-text">HP : <span id="enemyValue">100</span>/100</div>
    </div>

    <div id="question" class="question"></div>

    <button id="a" class="answer a" onclick="answer(0)"></button>
    <button id="b" class="answer b" onclick="answer(1)"></button>
    <button id="c" class="answer c" onclick="answer(2)"></button>
    <button id="d" class="answer d" onclick="answer(3)"></button>

    <div id="result" class="result"></div>
</div>

<script src="{{ asset('js/questions.js') }}"></script>

<script>
    // ブラウザ全体で見えるように window にデータをセット
    let playerHP = 100;
    let enemyHP = 100;
    let currentQuestionIndex = 0;

    // 問題を表示する関数（windowに付けることでボタンから呼び出せる）
    window.loadQuestion = function() {
        // window.questions は外部JSから読み込まれています
        if (!window.questions) {
            console.error("questionsが読み込めていません");
            return;
        }

        currentQuestionIndex = Math.floor(Math.random() * window.questions.length);
        const q = window.questions[currentQuestionIndex];
        
        document.getElementById("question").innerHTML = q.question;
        document.getElementById("a").innerHTML = q.choices[0];
        document.getElementById("b").innerHTML = q.choices[1];
        document.getElementById("c").innerHTML = q.choices[2];
        document.getElementById("d").innerHTML = q.choices[3];
    };

    // 回答判定関数（windowに付けることでボタンから呼び出せる）
    window.answer = function(index) {
        const q = window.questions[currentQuestionIndex];
        
        if (index === q.answer) {
            enemyHP = Math.max(0, enemyHP - 25);
            document.getElementById("enemyHp").style.width = enemyHP + "%";
            document.getElementById("enemyValue").innerHTML = enemyHP;
            document.getElementById("result").innerHTML = "Correct! Damage -25";
        } else {
            playerHP = Math.max(0, playerHP - 20);
            document.getElementById("playerHp").style.width = playerHP + "%";
            document.getElementById("playerValue").innerHTML = playerHP;
            document.getElementById("result").innerHTML = "Wrong! Damage -20";
        }

        if (enemyHP <= 0) {
            alert("Stage Clear!");
            window.location.href = "{{ route('game.easy') }}";
            return;
        }
        if (playerHP <= 0) {
            alert("Game Over");
            location.reload();
            return;
        }

        setTimeout(() => {
            document.getElementById("result").innerHTML = "";
            window.loadQuestion();
        }, 1000);
    };

    // 画面読み込み時に初回実行
    window.onload = window.loadQuestion;
</script>
@endsection