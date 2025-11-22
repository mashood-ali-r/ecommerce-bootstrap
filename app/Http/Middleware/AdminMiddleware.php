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
        // Simple admin check - in production, use proper authentication
        // For now, just allow access (you can add email check later)
        
        // Example: Check if user is logged in and is admin
        // if (!auth()->check() || !auth()->user()->is_admin) {
        //     return redirect('/')->with('error', 'Unauthorized access');
        // }
        
        return $next($request);
    }
}
