<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    
    Route::view('profile', 'profile')
        ->name('profile');
    
    Route::prefix('inquiry')->group(function () {
        Route::view('/', 'pages.inquiry.index')
            ->name('inquiry');
        Route::view('create', 'pages.inquiry.create')
            ->name('create-inquiry');
    });
});

require __DIR__.'/auth.php';
