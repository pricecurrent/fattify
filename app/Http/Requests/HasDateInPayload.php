<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

trait HasDateInPayload
{
    public function getDate()
    {
        try {
            return Carbon::parse($this->date);
        } catch (InvalidFormatException $e) {
            return today();
        }
    }
}
