<?php


use Illuminate\Support\Facades\Route;


Route::prefix('global')->group(function () {
    // // EVENT CATEGORY
    // Route::get('/event-categories', [EventCategoryController::class, 'index'])->name('global.event-category.index');
    // Route::get('/event-categories/{id}', [EventCategoryController::class, 'show'])->name('global.event-category.show');

    // // EVENT
    // Route::get('/events', [EventController::class, 'index'])->name('global.event.index');
    // Route::get('/events/{id}', [EventController::class, 'show'])->name('global.event.show');

    // // TICKET CATEGORY
    // Route::get('/ticket-categories/{eventId}', [TicketCategoryController::class, 'index'])->name('global.ticket-category.index');
    // Route::get('/ticket-categories/{eventId}/{ticketCategoryId}', [TicketCategoryController::class, 'show'])->name('global.ticket-category.show');

    // // Midtrans
    // Route::prefix('midtrans')->group(function () {
    //     Route::post('/callback', [MidtransController::class, 'callback'])->name('global.midtrans.callback');
    // });

    // // RERGION
    // Route::prefix('region')->group(function () {
    //     Route::get('/districts', [RegionController::class, 'indexDistrict'])->name('global.region.district.index');
    // });
});
