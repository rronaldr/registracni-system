<?php


use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.auth')->group(function () {
    Route::get('/{id}/dates', [EventController::class, 'getEventDates']);
    Route::post('/event/store', [EventController::class, 'store']);
});
