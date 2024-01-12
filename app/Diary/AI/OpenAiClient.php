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
                    "content" => "When providing a response, please include any previously generated suggestions. You provide response in the Json format as following: " . json_encode(['foods' => [['name' => 'food name', 'carbs' => 0, 'fats' => 0, 'proteins' => 0]]])
                ],
                [
                    "role" => "system",
                    "content" => "If it is impossible to provide calorie breakdown based on user prompt You provide response in the Json format as following: " . json_encode(['error' => '...'])
                ],
                [
                    "role" => "system",
                    "content" => "If you need more details to be able to provide accurate nutrients suggestions, replay with a clarifying question with the following format. But don't be to strict and don't try to argue the values user submits explicitly." . json_encode(['clarification' => '...'])
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
            throw AiSuggestionException::internalError($response['error']);
        }

        $response = json_decode($completion->choices[0]->message->content, true);

        if (isset($response['error'])) {
            throw AiSuggestionException::invalidPrompt($response['error']);
        }

        if (isset($response['clarification'])) {
            throw AiSuggestionException::needsClarification($response['clarification']);
        }

        return collect($response['foods'])->mapInto(Macronutrients::class);
    }
}
