<?php

namespace App\Http\Middleware;

use Closure;

class PelangganMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->user() && auth()->user()->role === 'pelanggan') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
