<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPost; 
use App\Models\Event;
use App\Models\Notification;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $marketItems = ItemPost::all();
        $workingSpots = ItemPost::all(); //仮
        $touristSpots = ItemPost::all(); //仮
        
        $events = Event::where('start_date', '>=', now())
                       ->orderby('start_date', 'asc')
                       ->take(5)
                       ->get();

        $notifications = Notification::latest()->take(3)->get();

        return view('home', compact('marketItems', 'workingSpots', 'touristSpots', 'events', 'notifications'));
    }
}
