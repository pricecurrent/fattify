<?php

use App\Http\Controllers\Api\UserDailyConsumptionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/daily-consumption', UserDailyConsumptionController::class)->name('api.daily-consumption');
});
