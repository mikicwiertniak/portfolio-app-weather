<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::view('dashboard', 'dashboard')
         ->name('dashboard');

});

Route::view('profile', 'profile')
     ->middleware(['auth'])
     ->name('profile');

require __DIR__ . '/auth.php';
