<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Authを使うために追加

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. ログインしていない、または 管理者ではない（is_admin が 1 ではない）場合
        // ※ usersテーブルの管理者判定カラム名（is_admin や role など）に合わせて調整
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // 条件に合わなければ、トップページ（またはログイン画面など）に強制転送
            return redirect('/')->with('error', 'You do not have administrator privileges.');
        }

        // 2. 管理者であれば、そのまま次の処理（コントローラーなど）へ進める
        return $next($request);
    }
}
