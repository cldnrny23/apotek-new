<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController;

Route::post('/checkout/token/{id}', [CheckoutController::class, 'getSnapToken'])->name('checkout.token');
Route::post('/checkout', [CheckoutController::class, 'toCheckout'])->name('checkout');
Route::post('/checkout/update', [CheckoutController::class, 'updateStatus'])->name('checkout.updateStatus');

Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('api.midtrans.notification');
