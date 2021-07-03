<?php

namespace App\Http\Requests;

class WriteCaloriesRequest extends StoreDiaryEntryRequest
{
    public function rules()
    {
        return [
            'calories' => 'required|integer|min:1',
            'meal_time' => 'nullable|in:breakfast,lunch,dinner',
        ];
    }
}
