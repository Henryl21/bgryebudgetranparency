<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrTreasurer
{
public function handle($request, Closure $next)
{
    if (auth('admin')->check() || auth('treasurer')->check()) {
        return $next($request);
    }

    return redirect()->route('welcome')->with('error', 'Unauthorized.');
}

}
