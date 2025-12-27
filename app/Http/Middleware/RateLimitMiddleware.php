<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $key = 'rate_limit:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 60)) {
            return response()->json(['message' => 'Too many requests'], 429);
        }

        RateLimiter::hit($key);

        return $next($request);
    }
}
