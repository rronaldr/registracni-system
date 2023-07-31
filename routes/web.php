<?php

use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('Admin')
    ->prefix('admin')
    ->group(__DIR__. '/admin.php');

// Date routes
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Event routes

// Form routes
Route::get('/enrollment/{id}', [EnrollmentController::class, 'show'])->name('enrollment.show');

// Auth routes

// Locale routes
Route::get('/{locale}', [LanguageController::class, 'setLocale'])->name('locale');
