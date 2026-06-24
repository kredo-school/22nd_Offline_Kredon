<?php

namespace App\Http\Controllers;

class GameController extends Controller
{
    public function home()
    {
        return view('game.home');
    }

    public function select()
    {
        return view('game.select');
    }

    public function easy()
    {
        return view('game.easy');
    }

    public function normal()
    {
        return view('game.normal');
    }

    public function hard()
    {
        return view('game.hard');
    }

    public function oni()
    {
        return view('game.oni');
    }

 public function stage11()
{
    return view('game.stage11');
}

public function battle()
{
    return view('game.battle');
}
}