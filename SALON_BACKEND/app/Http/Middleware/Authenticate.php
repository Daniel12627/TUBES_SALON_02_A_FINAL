<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        // Untuk API, biasanya tidak redirect, cukup null saja
        if (! $request->expectsJson()) {
            return route('login'); // atau bisa null juga kalau kamu full API
        }

        return null;
    }
}
