<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookmarkEntryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'weight' => ['required', 'integer', 'min:1', 'max:10000'],
        ];
    }
}
