<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class UserDailyConsumptionController
{
    public function __invoke(Request $request)
    {
        return response()->json(['data' => [
            'calories' => 2199,
            'fat' => 33,
            'carbs' => 120,
            'proteins' => 90,
        ]]);
    }
}
