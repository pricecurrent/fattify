<?php

namespace App\Models;

use App\Diary\AI\OpenAiClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NutriDialog extends Model
{
    use HasFactory;

    public function messages()
    {
        return $this->hasMany(NutriDialogMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formatMessagesForAi()
    {
        return $this->messages->map(fn ($message) => [
            'prompt' => $message->prompt,
            'suggestions' => $message->suggestions,
        ])
            ->flatMap(function ($item) {
                return [
                    [
                        'role' => 'user',
                        'content' => $item['prompt'],
                    ],
                    [
                        'role' => 'assistant',
                        'content' => json_encode($item['suggestions']),
                    ]
                ];
            })
            ->toArray();
    }

    public function prompt(string $prompt, OpenAiClient $client)
    {
        $suggestions = $client->getMacronutrientSuggestions($prompt, $this->formatMessagesForAi());

        $this->messages()->create([
            'uuid' => Str::uuid()->toString(),
            'prompt' => $prompt,
            'suggestions' => array_map(fn ($suggestion) => $suggestion->toArray(), $suggestions->toArray()),
        ]);
    }

    public function close()
    {
        $this->closed_at = now();
        $this->save();
    }

    public function isClosed()
    {
        return $this->closed_at !== null;
    }
}
