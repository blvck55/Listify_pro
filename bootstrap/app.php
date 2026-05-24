<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// FILE LOCATION: bootstrap/app.php
// PURPOSE: Application bootstrap — registers middleware aliases
// IMPORTANT: Replace your existing bootstrap/app.php with this.
//            The key addition is the withMiddleware section that
//            registers 'admin' as an alias for AdminMiddleware.

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register custom middleware aliases
        // This lets you use ->middleware('admin') on routes
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'adminOnly' => \App\Http\Middleware\AdminMiddleware::class,
            'redirect_admin_to_panel' => \App\Http\Middleware\HandleAdminRedirect::class,
        ]);

        // Global middleware for security headers
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Return JSON errors for all /api/* routes instead of HTML redirects
        $exceptions->shouldRenderJsonWhen(
            fn ($request) => $request->is('api/*')
        );
    })->create();
