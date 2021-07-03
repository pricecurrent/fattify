<?php

namespace App\Http\Requests;

class WriteMacronutrientsToDiaryRequest extends StoreDiaryEntryRequest
{
    public function withValidator($validator)
    {
        return $validator->sometimes(['fats'], ['required', 'min:1'], function ($input) {
            return 0 == $input->fats && 0 == $input->carbs && 0 == $input->proteins;
        });
    }

    public function rules()
    {
        return [
            'carbs' => ['nullable', 'integer', 'min:0'],
            'proteins' => ['nullable', 'integer', 'min:0'],
            'fats' => ['nullable', 'integer', 'min:0'],
            'date' => ['nullable', 'date'],
            'meal_time' => ['nullable', 'in:breakfast,lunch,dinner'],
        ];
    }
}
