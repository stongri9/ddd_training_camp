<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('shift', 'shift')
        ->name('shift');

    Route::view('dayoff', 'dayoff')
        ->name('dayoff');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::view('inquiry', 'inquiry')
        ->name('inquiry');
});

require __DIR__.'/auth.php';
