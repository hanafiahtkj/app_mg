<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin123')
        ->namespace('App\Http\Controllers\Admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', 'HomeController@index')->name('index');
            Route::get('/verifikasi/{id}', 'HomeController@verifikasi')->name('verifikasi');
            Route::post('/verifikasi', 'HomeController@store')->name('verifikasi.store');
            Route::get('loadTransactions', 'HomeController@loadTransactions')->name('loadTransactions');

            Route::get('users/loadUsers', 'UsersController@loadUsers')->name('users.loadUsers');
            Route::resource('users', UsersController::class);
        });
});

