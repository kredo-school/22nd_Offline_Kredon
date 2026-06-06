<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                                    ->latest()
                                    ->get();

        return view('notifications.index', compact('notifications'));
    }
    
    // 通知を既読にする機能
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => now()]);

        return back()->with('status', '通知を既読にしました');
    }
}
