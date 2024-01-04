<?php

use App\Http\Controllers\Api\AiAnalyzeController;
use App\Http\Controllers\Api\UserBookmarksController;
use App\Http\Controllers\Api\UserDailyConsumptionController;
use App\Http\Controllers\Api\UserNutritionDiaryEntriesController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/daily-consumption', UserDailyConsumptionController::class)->name('api.daily-consumption');

    Route::prefix('users/{user}')->group(function () {
        Route::get('nutrition-diary-entries', [UserNutritionDiaryEntriesController::class, 'index'])->name('api.user-nutrition-diary-entries.get');

        Route::get('bookmarks', [UserBookmarksController::class, 'index'])->name('api.user-bookmarks.index');
    });

    Route::post('analyze', AiAnalyzeController::class)->name('api.analyze');
});
