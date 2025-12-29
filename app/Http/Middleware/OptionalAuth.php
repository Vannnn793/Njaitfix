<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionalAuth
{
    public function handle(Request $request, Closure $next)
    {
        Auth::shouldUse('web'); // pakai guard web
        return $next($request);
    }
}
