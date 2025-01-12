<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    
    Route::view('profile', 'profile')
        ->name('profile');
    
    Route::view('inquiry', 'inquiry')
        ->name('inquiry');
});

require __DIR__.'/auth.php';
