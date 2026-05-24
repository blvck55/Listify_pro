<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent MIME type sniffing
        $response->header('X-Content-Type-Options', 'nosniff');

        // Enable XSS protection in older browsers
        $response->header('X-XSS-Protection', '1; mode=block');

        // Prevent clickjacking attacks
        $response->header('X-Frame-Options', 'DENY');

        // Control referrer information
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Content Security Policy
        // 'unsafe-eval' is required by Alpine.js (bundled in Livewire 3) which uses
        // new Function() for expression evaluation (wire:click, wire:model, etc.)
        $response->header('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net http://127.0.0.1:5174 http://localhost:5174; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com http://127.0.0.1:5174 http://localhost:5174; img-src 'self' data: https:; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; connect-src 'self' http://127.0.0.1:5174 http://localhost:5174 ws://127.0.0.1:5174 ws://localhost:5174; base-uri 'self'; frame-ancestors 'none';");

        // Enforce HTTPS
        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // Permissions Policy (formerly Feature-Policy)
        $response->header('Permissions-Policy', 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()');

        return $response;
    }
}
