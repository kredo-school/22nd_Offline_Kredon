<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title')</title>

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

</style>

</head>

<body>

@php

$music = 'Quest_on_Cebu_Sand.mp3';

// Battle
if(request()->routeIs(
    'game.battle',
    'game.stage11',
    'game.stage2',
    'game.stage2-1',
    'game.stage2-2',
    'game.stage2-3',
    'game.stage3',
    'game.stage3-1',
    'game.stage3-2',
    'game.stage3-3',
    'game.stageoni'
)){

    if(rand(1,10)==1){
        $music='kure.mp3';
    }else{
        $music='battle.mp3';
    }

}

// Boss
elseif(request()->routeIs(
    'game.boss',
    'game.stage2-boss',
    'game.stage3-boss'
)){

    $music='boss.mp3';

}

// Home・Select・Result
elseif(request()->routeIs(
    'game.home',
    'game.select',
    'game.result',
    'game.select-normal'
)){

    $music='Quest_on_Cebu_Sand.mp3';

}

// その他
else{

    if(rand(1,7)==1){
        $music='kuremiti.mp3';
    }

}

@endphp

@yield('content')

<audio id="bgm" autoplay loop>

    <source
        src="{{ asset('audio/'.$music) }}"
        type="audio/mpeg">

</audio>

<script>

window.addEventListener('load', () => {

    const bgm = document.getElementById('bgm');

    bgm.volume = 0.3;

    bgm.play().catch(() => {

        document.addEventListener('click', () => {

            bgm.play();

        }, { once:true });

    });

});

</script>

</body>
</html>