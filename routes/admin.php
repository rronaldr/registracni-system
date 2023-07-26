<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\BlacklistController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TemplateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    // Event routes
    Route::get('/', function () {
        return redirect()->route('admin.events');
    })->name('admin');
    Route::get('/events', [EventController::class, 'index'])->name('admin.events');
    Route::get('/events/create', [EventController::class, 'create'])->name('admin.events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('admin.events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('admin.events.destroy');
    Route::post('/events/{event}/duplicate', [EventController::class, 'duplicate'])->name('admin.events.duplicate');
    Route::get('/events/{event_id}/dates', [EventController::class, 'getEventDates'])->name('admin.events.dates');
    Route::get('/events/{event_id}/users', [EventController::class, 'getEventEnrollmentsUsers'])->name('admin.events.users');
    Route::get('/events/{event_id}/users/export', [EventController::class, 'exportEventUsers'])->name('admin.events.users.export');
    Route::get('/events/{event_id}/users/export-email', [EventController::class, 'exportEventUsersEmails'])->name('admin.events.users.export.email');

    // Blacklist routes
    Route::get('/blacklist', [BlacklistController::class, 'index'])->name('admin.blacklist');
    Route::post('/blacklist/store', [BlacklistController::class, 'store'])->name('admin.blacklist.store');
    Route::put('/blacklist/{blacklist_id}', [BlacklistController::class, 'update'])->name('admin.blacklist.update');
    Route::delete('/blacklist/{blacklist_id}/{email}', [BlacklistController::class, 'destroy'])->name('admin.blacklist.destroy');

    // Template routes
    Route::get('/templates', [TemplateController::class, 'index'])->name('admin.templates');
    Route::get('/templates/create', [TemplateController::class, 'create'])->name('admin.templates.create');
    Route::post('/templates/store', [TemplateController::class, 'store'])->name('admin.templates.store');
    Route::get('/templates/{id}/edit', [TemplateController::class, 'edit'])->name('admin.templates.edit');
    Route::put('/templates/{id}', [TemplateController::class, 'update'])->name('admin.templates.update');
    Route::delete('/templates/{id}', [TemplateController::class, 'destroy'])->name('admin.templates.destroy');
    Route::post('templates/{id}/send-test', [TemplateController::class, 'sendTest'])->name('admin.templates.send-test');
    Route::get('templates/approvals', [TemplateController::class, 'approvals'])->name('admin.templates.approvals');
    Route::post('templates/{id}/approve', [TemplateController::class, 'approve'])->name('admin.templates.approve');
    Route::get('templates/{user}/show-user', [TemplateController::class, 'showAuthorTemplates'])->name('admin.templates.author');

    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['guest'])->group(function () {
    // Auth routes
    Route::get('/register', [RegisterController::class, 'index'])->name('admin.register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login',[LoginController::class, 'index'])->name('admin.login');
    Route::post('/login',[LoginController::class, 'login']);

});
