<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.events');
})->name('admin.events');

Route::get('/roles', function () {
    return view('admin.roles');
})->name('admin.roles');

Route::get('/{id}/permissions', function ($id) {
    return view('admin.permissions', ['id' => $id]);
})->name('admin.permissions');
