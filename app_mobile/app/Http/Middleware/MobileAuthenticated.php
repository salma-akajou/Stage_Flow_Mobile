<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MobileAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('auth_token')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
