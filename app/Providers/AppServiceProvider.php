<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\NotificationRead;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

// User用の通知
use App\Http\Controllers\NotificationsController;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    // View Composerは、共通レイアウトがレンダリングされる前に、自動的に変数を注入する
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            $sentNotifications = Notification::where('status', 'sent')
                ->orderByDesc('sent_at')
                ->get();

            $readNotificationIds = [];
            $unreadNotificationsCount = 0;

            if (Auth::check()) {
                $readNotificationIds = NotificationRead::where('user_id', Auth::id())
                    ->whereIn('notification_id', $sentNotifications->pluck('id'))
                    ->pluck('notification_id')
                    ->toArray();

                $unreadNotificationsCount = $sentNotifications
                    ->whereNotIn('id', $readNotificationIds)
                    ->count();
            }

            $view->with([
                'sentNotifications' => $sentNotifications,
                'readNotificationIds' => $readNotificationIds,
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        });

        // User用
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                $view->with('notifications', NotificationsController::listForUser($userId));
                $view->with('unreadNotificationsCount', NotificationsController::unreadCountForUser($userId));
                $view->with('categoryLabels', NotificationsController::categoryLabels());
                $view->with('categoryIcons', NotificationsController::categoryIcons());
            } else {
                $view->with('notifications', []);
                $view->with('unreadNotificationsCount', 0);
                $view->with('categoryLabels', []);
                $view->with('categoryIcons', []);
            }
        });
    }
}
