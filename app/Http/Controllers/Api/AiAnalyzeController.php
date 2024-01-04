<?php

namespace App\Http\Controllers\Api;

use App\Diary\AI\OpenAiClient;
use Illuminate\Http\Request;

class AiAnalyzeController
{
    public function __invoke(OpenAiClient $client, Request $request)
    {
        $request->validate(['prompt' => ['string', 'required']]);

        $data = $client->getMacronutrientValues(request('prompt'));

        return response()->json(array_map(fn ($i) => $i->toArray(), $data->all()));
    }
}
