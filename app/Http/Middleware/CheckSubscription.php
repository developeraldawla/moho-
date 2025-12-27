<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $subscription = $user->activeSubscription;

        if (!$subscription || $subscription->status !== 'active') {
            return redirect()->route('subscription.index');
        }
        return $next($request);
    }
}
