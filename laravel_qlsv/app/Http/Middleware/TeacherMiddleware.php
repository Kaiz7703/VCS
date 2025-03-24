<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isTeacher()) {
            abort(403, 'Access denied. Teachers only.');
        }

        return $next($request);
    }
}
