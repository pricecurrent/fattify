<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DiaryEntries\IndexDiaryEntriesRequest;
use App\Http\Resources\NutritionDiaryEntryResource;
use App\Models\NutritionDiaryEntry;
use App\Models\User;

class UserNutritionDiaryEntriesController
{
    public function index(IndexDiaryEntriesRequest $request, User $user)
    {
        $entries = NutritionDiaryEntry::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('date', '=', $request->getDate())
            ->get();

        return NutritionDiaryEntryResource::collection($entries);
    }
}
