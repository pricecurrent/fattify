<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Diary\CaloriesDiaryEntriesController;
use App\Http\Controllers\Diary\MacronutrientsDiaryEntriesController;
use App\Http\Controllers\Diary\NutritionDiaryEntryBookmarksController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WelcomeController;

Route::get('/', WelcomeController::class)->name('welcome');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('diary/{date?}', DiaryController::class)->name('diary');
    Route::get('profile', ProfileController::class)->name('profile');
    Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update');

    Route::post('nutrition-diary-entries/calories', CaloriesDiaryEntriesController::class)->name('nutrition-diary-entries.calories.store');
    Route::post('nutrition-diary-entries/macronutrients', MacronutrientsDiaryEntriesController::class)->name('nutrition-diary-entries.macronutrients.store');

    Route::post('nutrition-diary-entries/{entry}/bookmarks', [NutritionDiaryEntryBookmarksController::class, 'store'])->name('nutrition-diary-entries.bookmarks.store');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->middleware('guest');
Route::get('register', [RegisterController::class, 'show'])->name('register')->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->name('register.store')->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth');
