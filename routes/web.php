<?php

use App\Livewire\Stripe;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', Stripe::class);
Route::get('payment/stripe/element', [StripeController::class, 'element'])->name('payment.stripe.element');
