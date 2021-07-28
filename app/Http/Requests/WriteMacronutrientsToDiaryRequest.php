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
            'carbs' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'proteins' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'fats' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'date' => ['nullable', 'date'],
            'meal_time' => ['nullable', 'in:breakfast,lunch,dinner,other'],
        ];
    }
}
