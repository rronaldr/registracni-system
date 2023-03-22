<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/events', [EventController::class, 'index'])->name('admin.events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
Route::post('/events/store', [EventController::class, 'store'])->name('admin.events.store');
Route::get('/events/{event}', [EventController::class, 'show'])->name('admin.events.show');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
Route::put('/events/{event}', [EventController::class, 'update'])->name('admin.events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
Route::post('/events/{event}/duplicate', [EventController::class, 'duplicate'])->name('admin.events.duplicate');

Route::get('/roles', function () {
    return view('admin.roles');
})->name('admin.roles');

Route::get('/{id}/permissions', function ($id) {
    return view('admin.permissions', ['id' => $id]);
})->name('admin.permissions');
