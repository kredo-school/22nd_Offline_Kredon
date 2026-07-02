<?php

namespace App\Providers;

use App\Http\Controllers\NotificationsController;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('components.ranking-list', function ($view) {
            $view->with('totalPlayers', User::count());
        });

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
