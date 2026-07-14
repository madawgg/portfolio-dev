<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Nadie puede embeber la web en un iframe (anti-clickjacking)
        $response->headers->set('X-Frame-Options', 'DENY');

        // El navegador no reinterpreta contenidos como otro MIME
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // No filtrar la URL completa como referer a sitios externos
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
