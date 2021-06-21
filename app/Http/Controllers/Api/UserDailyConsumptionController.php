<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Diary\DailyConsumption;
use Carbon\Exceptions\InvalidFormatException;

class UserDailyConsumptionController
{
    public function __invoke(Request $request)
    {
        try {
            $date = Carbon::parse($request->date);
        } catch (InvalidFormatException $e) {
            $date = today();
        }

        return response()->json(['data' => DailyConsumption::for($request->user())->onDate($date)->get()]);
    }
}
