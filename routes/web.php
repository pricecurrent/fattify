<?php

use App\Http\Controllers\DiaryController;
use App\Http\Controllers\Auth\LoginController;

Route::middleware('auth')->group(function () {
    Route::get('diary/{date?}', DiaryController::class)->name('diary');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth');
