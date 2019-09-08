<?php

namespace App\Http\Middleware;

use Closure;

class TrackLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            auth()->user()->update(['last_login' => now()]);
        }
        return $response;
    }
}
