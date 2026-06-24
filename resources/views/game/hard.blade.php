<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Stage Select</title>

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

/* ========================= */
/* 全画面 */
/* ========================= */

.stage-screen{
    position:relative;
    width:100vw;
    height:100vh;
}

/* 背景画像 */

.stage-screen img{
    position:absolute;
    inset:0;

    width:100%;
    height:100%;

    object-fit:fill;
}

/* ========================= */
/* 戻るボタン */
/* ========================= */

.back-btn{
    position:absolute;

    top:20px;
    left:20px;

    background:#000;
    color:#fff;

    padding:12px 24px;

    border-radius:12px;

    text-decoration:none;
    font-weight:bold;

    z-index:999;
}

/* ========================= */
/* ステージボタン */
/* ========================= */

.stage-link{
    position:absolute;
    display:block;
    z-index:100;
}

/* 1-1 */

.stage11{
    left:28%;
    top:17%;

    width:45%;
    height:13%;
}

/* 1-2 */

.stage12{
    left:28%;
    top:35%;

    width:45%;
    height:13%;
}

/* 1-3 */

.stage13{
    left:28%;
    top:53%;

    width:45%;
    height:13%;
}

/* BOSS */

.boss{
    left:28%;
    top:71%;

    width:45%;
    height:13%;
}

/* ========================= */
/* HOMEボタン */
/* ========================= */

.home-btn{
    position:absolute;

    left:42%;
    top:92%;

    width:16%;
    height:5%;

    z-index:100;
}

/* ========================= */
/* 確認用 */
/* ========================= */

.stage-link:hover,
.home-btn:hover{
    background:rgba(255,255,255,.2);
    border-radius:10px;
}

</style>

</head>

<body>

<div class="stage-screen">

<img src="{{ asset('images/stage-select-hard.png') }}"
     alt="Stage Select">

<!-- Back -->


<!-- Stage 1-1 -->
<a href="{{ route('game.stage3-1') }}"
   class="stage-link stage11">
</a>

<!-- Stage 1-2 -->
<a href="{{ route('game.stage3-2') }}"
   class="stage-link stage12">
</a>

<!-- Stage 1-3 -->
<a href="{{ route('game.stage3-3') }}"
   class="stage-link stage13">
</a>

<!-- Boss -->
<a href="{{ route('game.stage3-boss') }}"
   class="stage-link boss">
</a>

<!-- Home -->
<a href="{{ route('game.home') }}"
   class="home-btn">
</a>

</div>

</body>
</html>
