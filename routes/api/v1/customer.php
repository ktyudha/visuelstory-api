<?php

use App\Http\Controllers\Api\V1\Customer\Auth\AuthController;
use App\Http\Controllers\Api\V1\Customer\Customer\CustomerController;
use App\Http\Controllers\Api\V1\Customer\Event\EventController;
use App\Http\Controllers\Api\V1\Customer\Invoice\InvoiceController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    // Auth User
    Route::prefix('customer')->group(function () {
        Route::post('/send-otp', [AuthController::class, 'sendOtp'])->middleware('throttle:2,1')->name('customer.send-otp');
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:2,1')->name('customer.verify-otp');
        Route::get('/me', [AuthController::class, 'user'])->name('customer.me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('customer.logout');
    });
});


Route::prefix('customer')->group(function () {
    Route::prefix('invoices')->group(function () {
        Route::post('create-user', [CustomerController::class, 'firstOrCreate'])->name('invoices.create-user');
        Route::post('create-invoice', [InvoiceController::class, 'store'])->name('invoices.create-invoice');
        Route::post('create-event', [EventController::class, 'store'])->name('invoices.create-event');
    });

    Route::middleware('auth:apiCustomer')->group(function () {
        // History
        Route::get('/invoices/history', [InvoiceController::class, 'index'])->name('invoices.index');

        // Event
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
    });
});
