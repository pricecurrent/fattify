<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Diary\CaloriesDiaryEntriesController;
use App\Http\Controllers\Diary\MacronutrientsDiaryEntriesController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\ProfileController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('diary/{date?}', DiaryController::class)->name('diary');
    Route::get('profile', ProfileController::class)->name('profile');

    Route::post('nutrition-diary-entries/calories', CaloriesDiaryEntriesController::class)->name('nutrition-diary-entries.calories.store');
    Route::post('nutrition-diary-entries/macronutrients', MacronutrientsDiaryEntriesController::class)->name('nutrition-diary-entries.macronutrients.store');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth');
