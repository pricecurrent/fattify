<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiaryEntryRequest extends FormRequest
{
    public function __get($key)
    {
        if ('date' !== $key) {
            return parent::__get($key);
        }

        return $this->get('date') ? Carbon::parse($this->get('date')) : today();
    }
}
