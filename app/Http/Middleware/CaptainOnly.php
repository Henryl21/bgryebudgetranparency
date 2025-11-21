<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaptainOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();

        if (!$user || $user->role !== 'captain') {
            abort(403, 'Access denied: Only Captain can access this page.');
        }

        return $next($request);
    }
}
