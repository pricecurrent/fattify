<?php

namespace App\Http\Requests\DiaryEntries;

use App\Http\Filters\DateEqualsFitler;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Pricecurrent\LaravelEloquentFilters\Contracts\FilterableRequest;

class IndexDiaryEntriesRequest extends FormRequest implements FilterableRequest
{
    public function rules()
    {
        return [];
    }

    public function filters()
    {
        return [
            'date' => [
                'name' => DateEqualsFitler::class,
                'field' => 'date',
                'serializer' => fn ($value) => Carbon::parse($value),
            ],
        ];
    }

    public function authorize()
    {
        return $this->user()->is($this->route('user'));
    }
}
