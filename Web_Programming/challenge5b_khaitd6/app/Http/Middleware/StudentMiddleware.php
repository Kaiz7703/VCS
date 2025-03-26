<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isStudent()) {
            abort(403, 'Access denied. Students only.');
        }

        return $next($request);
    }
}
