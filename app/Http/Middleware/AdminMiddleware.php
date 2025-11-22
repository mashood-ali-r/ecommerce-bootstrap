<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access the admin panel.');
        }

        // Check if user is an admin
        if (!auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access. Admin privileges required.');
        }
        
        return $next($request);
    }
}
