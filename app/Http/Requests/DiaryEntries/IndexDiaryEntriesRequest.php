<?php

namespace App\Http\Requests\DiaryEntries;

use App\Http\Filters\DateEqualsFitler;
use App\Http\Requests\ExpectsDateInPayload;
use App\Http\Requests\HasDateInPayload;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class IndexDiaryEntriesRequest extends FormRequest implements ExpectsDateInPayload
{
    use HasDateInPayload;

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
