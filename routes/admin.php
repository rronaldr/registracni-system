<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\BlacklistController;
use App\Http\Controllers\Admin\DateController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:admin-access'])->group(function () {
    // Blacklist routes
    Route::middleware('can:blacklist-access')->group(function () {
        Route::get('/blacklist', [BlacklistController::class, 'index'])->name('admin.blacklist');
        Route::post('/blacklist/store', [BlacklistController::class, 'store'])->name('admin.blacklist.store');
        Route::get('/blacklist/{id}/users', [BlacklistController::class, 'getBlacklistUsers'])->middleware('can:blacklist-edit')->name('admin.blacklist.users');
        Route::put('/blacklist/{id}', [BlacklistController::class, 'update'])->middleware('can:blacklist-edit')->name('admin.blacklist.update');
        Route::delete('/blacklist/{id}/{user}', [BlacklistController::class, 'destroy'])->middleware('can:blacklist-user-delete')->name('admin.blacklist.destroy');
    });

    // Date routes
    Route::get('/dates/{id}', [DateController::class, 'getEventDates'])->name('admin.dates');
    Route::post('/dates/{id}/create', [DateController::class, 'store'])->name('admin.dates.store');
    Route::put('/dates/{id}/update', [DateController::class, 'update'])->name('admin.dates.update');
    Route::delete('/dates/{id}/delete', [DateController::class, 'destroy'])->name('admin.dates.destroy');
    Route::get('/dates/{id}/event', [DateController::class, 'getEventDates'])->name('admin.events.dates');
    Route::get('/dates/{id}/enrollments', [DateController::class, 'getDateEnrollments'])->name('admin.dates.enrollments');
    Route::post('/dates/enrollments/{id}/signoff', [DateController::class, 'signOffEnrollmentUser'])->name('admin.dates.enrollments.signoff');

    // Event routes
    Route::middleware('can:event-access')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.events');
        })->name('admin');
        Route::get('/events', [EventController::class, 'index'])->name('admin.events');
        Route::get('/events/create', [EventController::class, 'create'])->middleware('can:event-create')->name('admin.events.create');
        Route::post('/events/store', [EventController::class, 'store'])->middleware('can:event-create')->name('admin.events.store');
        Route::get('/events/{id}/edit', [EventController::class, 'edit'])->middleware('can:event-edit')->name('admin.events.edit');
        Route::put('/events/{id}/update', [EventController::class, 'update'])->middleware('can:event-edit')->name('admin.events.update');
        Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('can:event-delete')->name('admin.events.destroy');
        Route::post('/events/{id}/blacklist', [EventController::class, 'createAndGetBlacklistForEvent'])->middleware('can:event-create')->name('admin.events.blacklist.store');
        Route::get('/events/{id}/duplicate', [EventController::class, 'duplicate'])->middleware('can:event-create')->name('admin.events.duplicate');
        Route::get('/events/{id}/users', [EventController::class, 'getEventEnrollmentsUsers'])->name('admin.events.users');
        Route::get('/events/{id}/users/export', [EventController::class, 'exportEventUsers'])->name('admin.events.users.export');
        Route::get('/events/{id}/users/export-email', [EventController::class, 'exportEventUsersEmails'])->name('admin.events.users.export.email');
        Route::get('/events/{id}/tags', [EventController::class, 'getEventTags'])->name('admin.events.tags');
        Route::post('/events/{id}/tags/create', [EventController::class, 'storeEventTag'])->middleware('can:event-create')->name('admin.events.tags.store');
        Route::put('/events/{id}/tags/{tag}/update', [EventController::class, 'updateEventTag'])->middleware('can:event-edit')->name('admin.events.tags.update');
        Route::delete('/events/{id}/tags/{tag}/delete', [EventController::class, 'destroyEventTag'])->middleware('can:event-delete')->name('admin.events.tags.delete');
    });

    // Template routes
    Route::middleware('can:template-access')->group(function () {
        Route::get('/templates', [TemplateController::class, 'index'])->middleware('can:event-delete')->name('admin.templates');
        Route::get('/templates/create', [TemplateController::class, 'create'])->middleware('can:template-create')->name('admin.templates.create');
        Route::post('/templates/store', [TemplateController::class, 'store'])->middleware('can:template-create')->name('admin.templates.store');
        Route::get('/templates/{id}/edit', [TemplateController::class, 'edit'])->middleware('can:template-edit')->name('admin.templates.edit');
        Route::put('/templates/{id}', [TemplateController::class, 'update'])->middleware('can:template-edit')->name('admin.templates.update');
        Route::delete('/templates/{id}', [TemplateController::class, 'destroy'])->middleware('can:template-delete')->name('admin.templates.destroy');
        Route::post('templates/{id}/send-test', [TemplateController::class, 'sendTest'])->name('admin.templates.send-test');
        Route::get('templates/approvals', [TemplateController::class, 'showApprovals'])->middleware('template-approve')->name('admin.templates.approvals');
        Route::post('templates/{id}/approve', [TemplateController::class, 'approve'])->middleware('template-approve')->name('admin.templates.approve');
        Route::get('templates/approved', [TemplateController::class, 'getApprovedTemplates'])->name('admin.templates.approved');
        Route::get('templates/{user}/show-user', [TemplateController::class, 'showAuthorTemplates'])->name('admin.templates.author');
    });

    // User routes
    Route::middleware('can:user-access')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::get('/users/{search}', [UserController::class, 'findUser'])->name('admin.users.find');
        Route::get('/users/{id}/roles', [UserController::class, 'getUserByIdWithRoles'])->name('admin.users.roles.list');
        Route::post('/users/{id}/roles/assign', [UserController::class, 'assignRole'])->name('admin.users.roles.assign');
        Route::post('/users/{id}/roles/revoke', [UserController::class, 'revokeRole'])->name('admin.users.roles.revoke');
    });

});
