@extends('game.layout')

@section('title','KREDON Adventure')

@section('content')
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Expert Stage</title>

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
    background:#000;
}

.stage-screen{
    position:relative;
    width:100vw;
    height:100vh;
    overflow:hidden;
}

/* 背景画像 */

.stage-screen img{
    position:absolute;
    inset:0;

    width:100vw;
    height:100vh;

    object-fit:fill;
}

/* ===================== */
/* ボタン共通 */
/* ===================== */

.stage-link{
    position:absolute;
    display:block;
    z-index:100;
}

/* ===================== */
/* 1-1 左墓 */
/* ===================== */

.stage11{
    left:13%;
    top:40%;

    width:12%;
    height:18%;
}

/* ===================== */
/* 1-2 真ん中左墓 */
/* ===================== */

.stage12{
    left:34%;
    top:36%;

    width:13%;
    height:18%;
}

/* ===================== */
/* 1-3 真ん中右墓 */
/* ===================== */

.stage13{
    left:55%;
    top:35%;

    width:13%;
    height:18%;
}

/* ===================== */
/* BOSS 城 */
/* ===================== */

.boss{
    left:43%;
    top:12%;

    width:18%;
    height:22%;
}

/* ===================== */
/* HOME */
/* ===================== */

.home-btn{
    position:absolute;

    left:39%;
    top:83%;

    width:22%;
    height:9%;

    z-index:100;
}

/* ===================== */
/* BACK */
/* ===================== */

.back-btn{
    position:absolute;

    top:20px;
    left:20px;

    background:#000;
    color:#fff;

    padding:12px 24px;

    border-radius:10px;

    text-decoration:none;

    z-index:999;
}

/* ===================== */
/* 確認用 */
/* 完成したら消してOK */
/* ===================== */

.stage-link:hover,
.home-btn:hover{
    background:rgba(255,255,255,.2);
    border-radius:10px;
}

</style>

</head>

<body>

<div class="stage-screen">

<img src="{{ asset('images/stage-select-boss.png') }}"
     alt="Expert Stage">


<!-- 城 -->
<a href="{{ route('game.stageoni') }}" class="stage-link boss"></a>

<!-- X SELECT -->
<a href="{{ route('game.home') }}"
   class="home-btn">
</a>

</div>

</body>
</html>
