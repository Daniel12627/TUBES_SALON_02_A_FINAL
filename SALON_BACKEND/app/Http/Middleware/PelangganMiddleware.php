<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; // ← PERBAIKI DI SINI

class PelangganMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user instanceof \App\Models\Pelanggan) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized role'], 403);
    }
}
