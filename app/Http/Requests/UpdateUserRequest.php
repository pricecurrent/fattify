<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'daily_calories_goal' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
