<?php


use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/{id}/dates', [EventController::class, 'getEventDates']);
Route::post('/event/store', [EventController::class, 'store']);