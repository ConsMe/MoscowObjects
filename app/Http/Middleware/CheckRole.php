<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(401);
        }
        if (!$request->user()->isAccepted() || !in_array($request->user()->role, $roles)) {
            abort(403);
        }
        return $next($request);
    }
}
