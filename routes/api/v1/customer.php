<?php

use App\Http\Controllers\Api\V1\Customer\Customer\CustomerController;
use App\Http\Controllers\Api\V1\Customer\Invoice\InvoiceController;
use Illuminate\Support\Facades\Route;


Route::prefix('customer')->group(function () {
    Route::prefix('invoices')->group(function () {
        Route::post('create-user', [CustomerController::class, 'firstOrCreate'])->name('invoices.create-user');
        Route::post('create-invoice', [InvoiceController::class, 'store'])->name('invoices.create-invoice');
    });
});
