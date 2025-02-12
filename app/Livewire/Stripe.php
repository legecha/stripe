<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class Stripe extends Component
{
    /**
     * Validate the checkout form.
     */
    #[Renderless]
    public function validateCheckout(): void
    {
        $this->dispatch('order-validated');
    }

    /**
     * Submit the checkout form.
     */
    #[On('payment-setup')]
    #[Renderless]
    public function setupPayment(array $confirmationToken): void
    {
        /*$this->validate();*/

        // Create the payment in Stripe.
        try {
            $stripe = new StripeClient(config('stripe.secret_key'));
            $paymentIntent = $stripe->paymentIntents->create([
                'confirm' => true,
                'amount' => 12345,
                'currency' => 'gbp',
                'confirmation_token' => $confirmationToken['id'],
                'return_url' => 'https://stripe.test/?ok',
            ]);

            $paymentIntent = [
                'paymentIntent' => $paymentIntent,
                'error' => null,
            ];
        } catch (ApiErrorException $e) {
            $paymentIntent = [
                'paymentIntent' => null,
                'error' => $e->getMessage(),
            ];
        }

        if ($paymentIntent['paymentIntent']->status === 'requires_action') {
            $this->dispatch(
                'confirm-payment',
                clientSecret: $paymentIntent['paymentIntent']->client_secret,
            );
            return;
        }

        // call submit order from here!
        $this->confirmPayment($paymentIntent['paymentIntent']->id);
    }

    /**
     * Submit the order.
     */
    #[On('payment-confirmed')]
    #[Renderless]
    public function confirmPayment(string $paymentIntentId): void
    {
        dd($paymentIntentId);
    }
}
