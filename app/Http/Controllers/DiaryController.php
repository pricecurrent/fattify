<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DiaryController
{
    public function __invoke($date = null)
    {
        return inertia('Diary', [
            'user' => auth()->user(),
            'date' => $date ? Carbon::parse($date)->toDateString() : now()->toDateString(),
        ]);
    }

    public function foo(Request $request)
    {
        return response()->json([
            'data' => "your graph is good for {$request->date}",
        ]);
        // return redirect()->route('diary', ['date' => now()->addDays(random_int(1, 110))->toDateString()]);
    }
}
