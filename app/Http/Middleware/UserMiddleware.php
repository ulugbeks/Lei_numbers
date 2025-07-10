<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        if (!Auth::user()->isUser()) {
            // If logged in but not a regular user (e.g., admin), redirect appropriately
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('error', 'Access restricted to users only.');
            }
        }

        return $next($request);
    }
}