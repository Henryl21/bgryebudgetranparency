<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        // If user is already logged in, redirect them
        if (Auth::guard('web')->check()) {
            return redirect('/dashboard'); // Or any page you want
        }

        // Optionally, block access to /user/login entirely for guests
        if ($request->is('user/login')) {
            abort(404); // or redirect('/'); to hide page
        }

        return $next($request);
    }
}
