<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DiaryController
{
    public function __invoke(Request $request, $date = null)
    {
        return inertia('Diary', [
            'date' => $date ? Carbon::parse($date)->format('F d, Y') : now()->format('F d, Y'),
            'dailyCaloriesGoal' => $request->user()->daily_calories_goal,
            'nutriDialog' => $request->cookie('dialog_id')
                ? $request
                    ->user()
                    ->nutriDialogs()
                    ->with(['messages' => fn ($q) => $q->latest()])
                    ->find($request->cookie('dialog_id'))
                : null,

        ]);
    }
}
