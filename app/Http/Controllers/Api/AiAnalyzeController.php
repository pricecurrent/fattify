<?php

namespace App\Http\Controllers\Api;

use App\Diary\AI\OpenAiClient;

class AiAnalyzeController
{
    public function __invoke(OpenAiClient $client)
    {
        $data = $client->getMacronutrientValues(request('prompt'));

        return response()->json(array_map(fn ($i) => $i->toArray(), $data->all()));
    }
}
