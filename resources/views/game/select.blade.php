@extends('game.layout')

@section('title','Select Difficulty')

@section('content')

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

html,
body{
width:100%;
height:100%;
overflow:hidden;
}

.screen{
position:relative;
width:100vw;
height:100vh;
}

.screen img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

/* 難易度ボタン */

.btn{
position:absolute;
display:block;
cursor:pointer;
}

/* 初級 */
.easy{
left:22%;
top:43%;
width:13%;
height:40%;
}

/* 中級 */
.normal{
left:38%;
top:43%;
width:13%;
height:40%;
}

/* 上級 */
.hard{
left:54%;
top:43%;
width:13%;
height:40%;
}

/* 鬼 */
.oni{
left:70%;
top:43%;
width:13%;
height:40%;
}

/* 戻る */

.back{
position:absolute;

top:20px;
left:20px;

background:white;
color:black;

padding:12px 20px;

border-radius:10px;

text-decoration:none;

font-weight:bold;

z-index:999;
}

/* ボタン位置確認 */
.btn:hover{
background:rgba(255,255,255,.15);
}

</style>

</head>

<body>

<div class="screen">

<img src="{{ asset('images/kredon-select.png') }}">

<a href="{{ route('game.home') }}"
   class="back">
   ← HOME
</a>

<a href="{{ route('game.easy') }}"
   class="btn easy"></a>

<a href="{{ route('game.normal') }}"
   class="btn normal"></a>

<a href="{{ route('game.hard') }}"
   class="btn hard"></a>

<a href="{{ route('game.oni') }}"
   class="btn oni"></a>

</div>

</body>
</html>