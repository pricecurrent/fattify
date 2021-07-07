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
                new Macronutrients($request->only('carbs', 'fats', 'proteins')),
                $request->meal_time,
                $request->dish_name
            );

        return redirect()->route('diary')->with('success', 'Great all done!');
    }
}
