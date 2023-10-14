<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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
    ->group(__DIR__.'/admin.php');

// Date routes
Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

// Event routes

// Form routes
Route::middleware(['auth'])->group(function () {
    Route::get('/enrollment/{date_id}', [EnrollmentController::class, 'show'])->name('enrollment.show');
    Route::post('/enrollment/{date_id}', [EnrollmentController::class, 'store'])->name('enrollment.store');
    Route::get('/enrollment/user/{id}', [EnrollmentController::class, 'getUserEnrollments'])->name('enrollment.user');
});


// Auth routes
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/login/shibboleth', [LoginController::class, 'shibbolethLogin'])->name('login.shibboleth');
Route::get('/login/graduate', [LoginController::class, 'graduateLogin'])->name('login.graduate');
Route::get('/login/external', [LoginController::class, 'externalLogin'])->name('login.external');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout/external', [LoginController::class, 'logoutExternal'])->name('logout.external');
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Locale routes
Route::get('/{locale}', [LanguageController::class, 'setLocale'])->name('locale');
