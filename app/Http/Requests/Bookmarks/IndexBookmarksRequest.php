<?php

namespace App\Http\Requests\Bookmarks;

use Illuminate\Foundation\Http\FormRequest;

class IndexBookmarksRequest extends FormRequest
{
    public function authorize()
    {
        return $this->route('user')->id == $this->user()->id;
    }

    public function rules()
    {
        return [];
    }
}
