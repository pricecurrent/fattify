<?php

namespace App\Http\Controllers\Diary;

use App\Diary\CaloriesCalculator;
use App\Http\Requests\BookmarkEntryRequest;
use App\Models\Bookmark;
use App\Models\NutritionDiaryEntry;

class BookmarkedNutritionDiaryEntriesController
{
    protected $calculator;

    public function __construct(CaloriesCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function store(NutritionDiaryEntry $entry, BookmarkEntryRequest $request)
    {
        Bookmark::createFromEntry($entry, $request->user(), $request->weight, $request->name);

        return redirect()->route('diary')->with('success', 'Great, all done!');
    }
}
