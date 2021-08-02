<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookmarkEntryRequest extends FormRequest
{
    public function authorize()
    {
        return $this->entry->user_id === $this->user()->id;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
