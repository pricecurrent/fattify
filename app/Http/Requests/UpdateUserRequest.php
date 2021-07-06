<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'min:1'],
            'bio' => ['nullable', 'string', 'min:2'],
            'avatar' => ['nullable', 'file', 'mimes:png,jpg,jpeg,gif,svg'],
            'daily_calories_goal' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
