<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spot;
class StudyController extends Controller
{
    public function index()
    {
        $spots = Spot::all();

        return view('welcome', compact('spots'));
    }
}
