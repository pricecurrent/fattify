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

    public function getMacronutrientValues(string $prompt): Collection
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
                    "role" => "user",
                    "content" => "I ate omelette with 3 egg whites and 1 whole egg. I have eaten a slice of bread around 100g. Hummus 50g"
                ],
                [
                    "role" => "assistant",
                    "content" => json_encode([
                        'foods' => [
                            ['name' => 'omelette', 'carbs' => 0, 'fats' => 5, 'proteins' => 20],
                            ['name' => 'bread', 'carbs' => 60, 'fats' => 5, 'proteins' => 8],
                            ['name' => 'hummus', 'carbs' => 15, 'fats' => 31, 'proteins' => 8],
                        ],
                    ])
                ],
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

        return collect(json_decode(json_decode($completion)->choices[0]->message->content, true)['foods'])
            ->mapInto(Macronutrients::class);
    }
}
