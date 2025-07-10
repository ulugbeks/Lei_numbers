<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Check if we're on admin login page
                if ($request->is('backend') || $request->is('backend/login')) {
                    // If user is already logged in as admin, redirect to admin dashboard
                    if ($user->isAdmin()) {
                        return redirect()->route('admin.dashboard');
                    }
                    // If regular user trying to access admin login, let them see the page
                    // They'll get an error when trying to login
                    Auth::logout();
                    return $next($request);
                }
                
                // For regular login page, redirect based on user role
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('user.profile');
                }
            }
        }

        return $next($request);
    }
}