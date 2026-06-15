<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) { // to check if the user is even logged in
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) { // to check if the user has the role we expect
            return redirect()->route('dashboard')->with('error', 'Access Denied: You do not have permission to view this page.');
        }

        return $next($request);
    }
}
