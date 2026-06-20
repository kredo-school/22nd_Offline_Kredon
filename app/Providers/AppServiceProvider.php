<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User; // ユーザーモデルを読み込む
use Illuminate\Support\Facades\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 'ranking' というファイル名のViewが呼ばれたら、自動的に $totalPlayers を渡す
        View::composer('components.ranking-list', function ($view) {
        $view->with('totalPlayers', User::count());
    });
    }
}
