<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DiaryEntries\IndexDiaryEntriesRequest;
use App\Models\NutritionDiaryEntry;
use App\Models\User;
use App\Transformers\NutritionDiaryEntryTransformer;
use Pricecurrent\LaravelEloquentFilters\QueryFilters;

class UserNutritionDiaryEntriesController
{
    public function index(IndexDiaryEntriesRequest $request, User $user)
    {
        $entries = NutritionDiaryEntry::query()
            ->filter(QueryFilters::makeFromRequest($request))
            ->get();

        return fractal($entries, new NutritionDiaryEntryTransformer())->respond();
    }
}
