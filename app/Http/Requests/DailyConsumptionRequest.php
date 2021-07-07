<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyConsumptionRequest extends FormRequest implements ExpectsDateInPayload
{
    use HasDateInPayload;

    public function rules()
    {
        return [];
    }
}
