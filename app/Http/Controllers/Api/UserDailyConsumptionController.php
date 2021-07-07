<?php

namespace App\Http\Controllers\Api;

use App\Diary\DailyConsumption;
use App\Http\Requests\DailyConsumptionRequest;

class UserDailyConsumptionController
{
    public function __invoke(DailyConsumptionRequest $request)
    {
        return response()->json(['data' => DailyConsumption::for($request->user())->onDate($request->getDate())->get()]);
    }
}
