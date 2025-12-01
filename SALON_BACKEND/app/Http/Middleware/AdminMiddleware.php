<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah user instance dari model Admin
        if ($user instanceof Admin) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized role'
        ], 403);
    }
}
