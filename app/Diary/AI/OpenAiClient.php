<?php

namespace App\Diary\AI;

use App\Diary\Macronutrients;
use Illuminate\Support\Collection;
use Orhanerday\OpenAi\OpenAi as BaseOpenAiClient;

class OpenAiClient
{
    public function __construct(public BaseOpenAiClient $client)
    {
    }

    public function getModels()
    {
        return $this->client->listModels();
    }

    public function getMacronutrientSuggestions(string $prompt, array $messages = []): Collection
    {
        $completion = $this->client->chat([
            'model' => 'gpt-4-1106-preview',
            'response_format' => ["type" => "json_object"],
            'messages' => [
                [
                    "role" => "system",
                    "content" => "You are a helpful assistant that is expert in nutritional information who can provide macronutrients for the food. You provide the response in json format"
                ],
                [
                    "role" => "system",
                    "content" => "You provide response in the Json format as following: " . json_encode(['foods' => [['name' => 'food name', 'carbs' => 0, 'fats' => 0, 'proteins' => 0]]])
                ],
                [
                    "role" => "system",
                    "content" => "If it is impossible to provide calorie breakdown based on user prompt You provide response in the Json format as following: " . json_encode(['error' => '...'])
                ],
                ...$messages,
                [
                    "role" => "user",
                    "content" => $prompt,
                ],

            ],
            // 'temperature' => 1.0,
            // 'max_tokens' => 4000,
            // 'frequency_penalty' => 0,
            // 'presence_penalty' => 0,
        ]);

        $completion = json_decode($completion);

        if (isset($completion->error)) {
            throw new AiSuggestionException($completion->error->message);
        }

        $response = json_decode($completion->choices[0]->message->content, true);

        if (isset($response['error'])) {
            throw new AiSuggestionException($response['error']);
        }

        return collect($response['foods'])->mapInto(Macronutrients::class);
    }
}
