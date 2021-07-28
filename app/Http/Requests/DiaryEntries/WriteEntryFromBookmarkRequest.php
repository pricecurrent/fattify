<?php

namespace App\Http\Requests\DiaryEntries;

use App\Http\Requests\StoreDiaryEntryRequest;

class WriteEntryFromBookmarkRequest extends StoreDiaryEntryRequest
{
    public function rules()
    {
        return [
            'bookmark_id' => ['required', 'exists:bookmarks,id'],
            'weight' => ['required', 'integer', 'min:1'],
            'meal_time' => 'nullable|in:breakfast,lunch,dinner,other',
        ];
    }
}
