<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TreasurerAuth
{
    public function handle($request, Closure $next)
{
    if (!auth()->guard('treasurer')->check()) {
        return redirect()->route('treasurer.login');
    }

    return $next($request);
}
}
