<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! $request->user() || $request->user()->role !== $role) {
            abort(404, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}