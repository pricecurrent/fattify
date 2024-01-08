<?php

namespace App\Http\Controllers\Diary;

use App\Http\Requests\BookmarkEntryRequest;
use App\Models\NutritionDiaryEntry;

class BookmarkedNutritionDiaryEntriesController
{
    public function store(NutritionDiaryEntry $entry, BookmarkEntryRequest $request)
    {
        $entry->bookmarkAs($request->name);

        return redirect()->route('diary')->with('success', 'Great, all done!');
    }
}
