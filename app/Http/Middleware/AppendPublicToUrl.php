<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppendPublicToUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the current URL path
        $path = $request->path();
        
        // Check if we're not already in the public segment
        if (!str_starts_with($path, 'public/') && $path !== '/') {
            // Redirect to the same path with 'public' prepended
            return redirect('public/' . $path);
        }

        return $next($request);
    }
}
