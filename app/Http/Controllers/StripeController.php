<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Safelincs\NexusCore\Actions\Order\Payment\Stripe\CreatePaymentIntent;

class StripeController extends Controller
{
    /**
     * Get the data required to create a Stripe element.
     */
    public function element(): JsonResponse
    {
        $total = 12345;

        return response()->json([
            'publishable_key' => config('stripe.publishable_key'),
            'csrf_token' => csrf_token(),
            'amount' => $total,
            'currency' => 'gbp',
        ]);
    }
}
