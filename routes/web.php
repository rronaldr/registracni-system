<?php

use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LoginController;
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
Route::get('/enrollment/{date_id}', [EnrollmentController::class, 'show'])->name('enrollment.show');
Route::post('/enrollment/{date_id}', [EnrollmentController::class, 'store'])->name('enrollment.store');

// Auth routes
Route::get('/login', [LoginController::class, 'shibbolethLogin'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Locale routes
Route::get('/{locale}', [LanguageController::class, 'setLocale'])->name('locale');
