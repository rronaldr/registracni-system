<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\EventController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.events.index');
    })->name('admin');
    Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('admin.events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    Route::post('/events/{event}/duplicate', [EventController::class, 'duplicate'])->name('admin.events.duplicate');
    Route::get('/events/{event_id}/dates', [EventController::class, 'getEventDates'])->name('admin.events.dates');
    Route::get('/events/{event_id}/users', [EventController::class, 'getEventEnrollmentsUsers'])->name('admin.events.users');
    Route::get('/events/{event_id}/users/export', [EventController::class, 'exportEventUsers'])->name('admin.events.users.export');
    Route::get('/events/{event_id}/users/export-email', [EventController::class, 'exportEventUsersEmails'])->name('admin.events.users.export.email');

    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('admin.register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login',[LoginController::class, 'index'])->name('admin.login');
    Route::post('/login',[LoginController::class, 'login']);

});
