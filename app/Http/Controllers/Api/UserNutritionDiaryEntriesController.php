<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DiaryEntries\IndexDiaryEntriesRequest;
use App\Models\NutritionDiaryEntry;
use App\Models\User;
use App\Transformers\NutritionDiaryEntryTransformer;

class UserNutritionDiaryEntriesController
{
    public function index(IndexDiaryEntriesRequest $request, User $user)
    {
        $entries = NutritionDiaryEntry::query()
            ->whereDate('date', '=', $request->getDate())
            ->get();

        return fractal($entries, new NutritionDiaryEntryTransformer())->respond();
    }
}
