<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)->orderBy('sort_order')->get();
        return view('dashboard.subscription.index', compact('plans'));
    }

    public function checkout(Request $request, Plan $plan)
    {
        $user = Auth::user();

        // Ensure user has a Stripe Customer ID description
        if (!$user->stripe_id) {
            $user->createAsStripeCustomer();
        }

        return $request->user()
            ->newSubscription('default', $plan->stripe_price_id)
            ->trialDays($plan->trial_days)
            ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('dashboard', ['checkout' => 'success']),
                'cancel_url' => route('subscription.index'),
            ]);
    }

    public function portal(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('dashboard'));
    }
}
