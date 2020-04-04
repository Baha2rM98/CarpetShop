<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard === 'admin') {
            if (Auth::guard($guard)->check()) {
                return redirect('/administrator/');
            }
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
