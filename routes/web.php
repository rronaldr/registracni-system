<?php

use App\Http\Controllers\DateController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
Route::get('/', [DateController::class, 'index'])->name('events');

// Event routes

// Form routes

// Auth routes

// Locale routes
Route::get('/{locale}', [LanguageController::class, 'setLocale'])->name('locale');
