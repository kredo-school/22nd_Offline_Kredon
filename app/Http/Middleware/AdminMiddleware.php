<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // role: 1 = admin, 2 = user(default), 3 = premium member
        if (!Auth::check() || (int) Auth::user()->role !== 1) {
            return redirect('/')->with('error', 'You do not have administrator privileges.');
        }

        return $next($request);
    }
}