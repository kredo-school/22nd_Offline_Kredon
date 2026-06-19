<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $templates = \App\Models\NotificationTemplate::orderByDesc('created_at')->get();

        // どのタブを開いた状態で表示するか (Template作成後のリダイレクト先指定用)
        $activeTab = $request->query('tab', 'list');

        return view('admin.notifications.index', compact('templates', 'activeTab'));
    }
}