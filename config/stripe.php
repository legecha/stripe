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
    'secret_key' => env($isProduction ? 'STRIPE_SECRET_KEY_PROD' : 'STRIPE_SECRET_KEY_TEST'),

    /*
    |--------------------------------------------------------------------------
    | Publishable Key
    |--------------------------------------------------------------------------
    |
    | This is the key used for public assets, such as when using Stripe.js Elemenets.
    |
    */
    'publishable_key' => env($isProduction ? 'STRIPE_PUBLISHABLE_KEY_PROD' : 'STRIPE_PUBLISHABLE_KEY_TEST'),

];
