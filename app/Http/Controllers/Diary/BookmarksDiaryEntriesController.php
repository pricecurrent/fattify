<?php

namespace App\Http\Controllers\Diary;

use App\Http\Requests\DiaryEntries\WriteEntryFromBookmarkRequest;
use App\Models\Bookmark;

class BookmarksDiaryEntriesController
{
    public function store(WriteEntryFromBookmarkRequest $request)
    {
        $bookmark = Bookmark::find($request->bookmark_id);
        $request->user()
            ->openDiaryOnDate($request->getDate())
            ->writeFromBookmark($bookmark, $request->weight, $request->meal_time);

        return redirect(route('diary'))->with('success', 'Great all set!');
    }
}
