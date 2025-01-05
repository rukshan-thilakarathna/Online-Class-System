<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckLoginStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is already authenticated by checking the session
        if (Session::has('user_id')) {
            return redirect()->route('dashboard'); // Redirect to home if logged in
        }

        return $next($request); // Continue to the next request if not logged in
    }
}
