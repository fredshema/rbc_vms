<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            if ($user->hasRole('driver')) {
                return $next($request);
            }

            if ($user->hasRole('staff')) {
                return redirect()->route('dashboard');
            }

            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            }
        }

        abort(403);
    }
}
