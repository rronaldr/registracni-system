<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\UserController;
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
Route::get('/events', [EventController::class, 'getEvents'])->name('events.get');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{id}/dates', [EventController::class, 'getEventActiveDates'])->name('events.get.dates');

// Event routes

// Form routes
Route::middleware(['auth'])->group(function () {
    Route::get('/enrollment/{date_id}', [EnrollmentController::class, 'show'])->name('enrollment.show');
    Route::post('/enrollment/{date_id}', [EnrollmentController::class, 'store'])->name('enrollment.store');
    Route::get('/enrollment/user/{id}', [EnrollmentController::class, 'getUserEnrollments'])->name('enrollment.user');
    Route::post('/enrollment/{id}/signoff', [EnrollmentController::class, 'signOff'])->name('enrollment.user.singoff');

    Route::get('/change-password', [UserController::class, 'changePassword'])->name('auth.change-password');
    Route::post('/change-password', [UserController::class, 'storeChangedPassword'])->name('auth.change-password.store');
});


// Auth routes
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/login/shibboleth', [LoginController::class, 'shibbolethLogin'])->name('login.shibboleth');
Route::get('/login/alumni', [LoginController::class, 'alumniLogin'])->name('login.alumni');
Route::get('/login/alumni/process', [LoginController::class, 'processAlumniLogin'])->name('login.alumni.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout/external', [LoginController::class, 'logoutExternal'])->name('logout.external');
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Locale routes
Route::get('/{locale}', [LanguageController::class, 'setLocale'])->name('locale');
Route::get('/locale/get', [LanguageController::class, 'getLocale'])->name('locale.get');
Route::get('/date/{id}/enroll/{email}', [EnrollmentController::class, 'signSubstituteByEmail'])->name('date.enroll.email');

// Iframe routes
Route::get('/external/login', [LoginController::class, 'iframeIndex'])->name('iframe.login.index');
Route::get('/external/enrollment/{id}', [EnrollmentController::class, 'iframeShow'])->middleware('iframe')->name('iframe.enrollment');