<?php

$isProduction = env('APP_ENV') === 'production';

return [

    /*
    |--------------------------------------------------------------------------
    | Secret Key
    |--------------------------------------------------------------------------
    |
    | This is the secret key used to authorise API requests to Stripe.
    |
    */
    'secret_key' => env('STRIPE_SECRET_KEY_TEST'),

    /*
    |--------------------------------------------------------------------------
    | Publishable Key
    |--------------------------------------------------------------------------
    |
    | This is the key used for public assets, such as when using Stripe.js Elemenets.
    |
    */
    'publishable_key' => env('STRIPE_PUBLISHABLE_KEY_TEST'),

];
