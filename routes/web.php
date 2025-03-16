<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'pages.dashboard')->name('dashboard');

    Route::view('shift', 'pages.shift')->name('shift');
    Route::view('shift/edit', 'pages.shift.edit')->name('shift.edit');
    Route::view('shift/unpublished', 'pages.shift.unpublished')->name('shift.unpublished');

    Route::view('dayoff', 'pages.dayoff')->name('dayoff');

    Route::view('profile', 'pages.profile')->name('profile');

    Route::view('inquiry', 'pages.inquiry')->name('inquiry');
});

require __DIR__.'/auth.php';
