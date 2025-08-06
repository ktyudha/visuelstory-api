<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\Auth\AuthController;
use App\Http\Controllers\Api\V1\User\Package\PackageAddOnController;
use App\Http\Controllers\Api\V1\User\Package\PackageCategoryController;
use App\Http\Controllers\Api\V1\User\Package\PackageController;

// use App\Http\Controllers\History\UserHistoryController;
// use App\Http\Controllers\Invoice\InvoiceController;
// use App\Http\Controllers\Ticket\UserTicketController;

Route::prefix('auth')->group(function () {
    // Auth User
    Route::prefix('admin')->group(function () {
        Route::post('/send-otp', [AuthController::class, 'sendOtp'])->middleware('throttle:2,1')->name('user.send-otp');
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('user.verify-otp');
        Route::get('/me', [AuthController::class, 'user'])->name('user.me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
    });
});

// User
Route::middleware('auth:apiUser')->group(function () {
    Route::prefix('admin')->group(function () {

        // Pacakage
        Route::apiResource('package-categories', PackageCategoryController::class)->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);
        Route::apiResource('package-addons', PackageAddOnController::class)->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);
        Route::apiResource('packages', PackageController::class)->only([
            'index',
            'store',
            'update',
            'destroy'
        ]);

        // // TICKET
        // Route::get('/tickets/{id}', [UserTicketController::class, 'show'])->name('user.ticket.show');

        // // INVOICE
        // Route::get('/invoices', [InvoiceController::class, 'index'])->name('user.invoice.index');
        // Route::post('/invoices', [InvoiceController::class, 'store'])->name('user.invoice.create');
        // Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('user.invoice.show');

        // // HISTORY
        // Route::get('/history', [UserHistoryController::class, 'index'])->name('user.history.index');
        // Route::get('/history/{id}', [UserHistoryController::class, 'show'])->name('user.history.show');
    });
});
