<?php

namespace App\Http\Middleware;

use Closure;

class CacheControlMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Set cache control headers
        $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
