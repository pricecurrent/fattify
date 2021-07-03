<?php

namespace App\Http\Controllers\Diary;

use App\Http\Requests\WriteCaloriesRequest;
use App\Models\NutritionDiaryEntry;

class CaloriesDiaryEntriesController
{
    public function __invoke(WriteCaloriesRequest $request)
    {
        NutritionDiaryEntry::create([
            'user_id' => $request->user()->id,
            'date' => $request->date,
            'calorie' => $request->calories,
            'meal_time' => $request->meal_time,
            'dish_name' => $request->dish_name,
        ]);

        return redirect()->route('diary')->with('success', 'That\'s dope');
    }
}
