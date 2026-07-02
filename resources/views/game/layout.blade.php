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

@yield('content')

<audio id="bgm" autoplay loop>

```
<source
    src="{{ asset('audio/Quest_on_Cebu_Sand.mp3') }}"
    type="audio/mpeg">
```

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
