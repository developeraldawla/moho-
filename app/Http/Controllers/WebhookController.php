<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Illuminate\Support\Facades\Log;
use App\Models\UserSubscription;
use App\Models\Plan;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class WebhookController extends CashierController
{
    /**
     * Handle Stripe Webhook.
     * Verify Signature manually if not using Cashier's default route.
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Stripe Webhook Error: Invalid Payload');
            return response('Invalid Payload', 400);
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Stripe Webhook Error: Invalid Signature');
            return response('Invalid Signature', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'customer.subscription.created':
            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdate($event->data->object);
                break;
            case 'invoice.payment_succeeded':
                $this->handleInvoicePaymentSucceeded($event->data->object);
                break;
            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;
            default:
            // Unexpected event type
            // Log::info('Received unknown event type ' . $event->type);
        }

        return response('Webhook Handled', 200);
    }

    protected function handleSubscriptionUpdate($subscription)
    {
        // Custom logic to sync local DB if needed beyond Cashier
        // Cashier handles this automatically if using Billable trait, but we might want custom logs
        Log::info("Subscription Updated: " . $subscription->id);
    }

    protected function handleInvoicePaymentSucceeded($invoice)
    {
        Log::info("Payment Succeeded for Invoice: " . $invoice->id);
        // Reset usage limits?
        // Maybe logic to grant credits
    }

    protected function handleSubscriptionDeleted($subscription)
    {
        Log::info("Subscription Canceled: " . $subscription->id);
    }
}
