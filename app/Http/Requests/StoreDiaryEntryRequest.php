<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiaryEntryRequest extends FormRequest implements ExpectsDateInPayload
{
    use HasDateInPayload;
}
