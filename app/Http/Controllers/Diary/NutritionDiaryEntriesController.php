<?php

namespace App\Http\Controllers\Diary;

use App\Models\NutritionDiaryEntry;

class NutritionDiaryEntriesController
{
    public function destroy(NutritionDiaryEntry $nutritionDiaryEntry)
    {
        $nutritionDiaryEntry->delete();

        return redirect()->back()->with('success', 'Entry deleted');
    }
}
