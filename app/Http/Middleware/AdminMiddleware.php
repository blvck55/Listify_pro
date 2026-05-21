<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// FILE LOCATION: app/Http/Middleware/AdminMiddleware.php
//
// VIVA: "Middleware runs BEFORE the route handler. It's like a security guard
//        at a door. The auth middleware checks if someone is logged in. My
//        AdminMiddleware additionally checks if they have the admin role.
//        If not, they get a 403 Forbidden error immediately."
//
// REGISTER IT: In bootstrap/app.php, add:
//   $middleware->alias(['admin' => \App\Http\Middleware\AdminMiddleware::class]);

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request  — The HTTP request coming in
     * @param Closure $next     — The next handler in the pipeline
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Step 1: Is the user even logged in?
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Step 2: Is the logged-in user an admin?
        if (Auth::user()->role !== 'admin') {
            // abort() stops everything and returns an HTTP error response
            abort(403, 'Access denied. This area is for administrators only.');
        }

        // Step 3: All checks passed — allow the request through
        return $next($request);
    }
}
