<?php

namespace App\Http\Controllers\Diary;

use App\Diary\Macronutrients;
use App\Http\Requests\WriteMacronutrientsToDiaryRequest;

class MacronutrientsDiaryEntriesController
{
    public function __invoke(WriteMacronutrientsToDiaryRequest $request)
    {
        $request->user()
            ->openDiaryOnDate($request->getDate())
            ->writeMacronutrients(
                macronutrients: new Macronutrients($request->only('carbs', 'fats', 'proteins')),
                mealTime: $request->meal_time,
                dishName: $request->dish_name,
                weight: $request->weight
            );

        return redirect()->route('diary')->with('success', 'Great all done!');
    }
}
