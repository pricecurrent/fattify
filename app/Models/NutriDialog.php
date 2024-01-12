<?php

namespace App\Models;

use App\Diary\AI\AiSuggestionException;
use App\Diary\AI\AiSuggestionExceptionReason;
use App\Diary\AI\NutriDialogMessageType;
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

    public static function retrieve(?string $dialogId)
    {
        return $dialogId
            ? static::whereUuid($dialogId)->firstOrFail()
            : static::create([
                'uuid' => Str::uuid()->toString(),
                'user_id' => auth()->user()->id,
            ]);
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

    public function ask(string $prompt, OpenAiClient $client)
    {
        $message = $this->messages()->make([
            'uuid' => Str::uuid()->toString(),
            'prompt' => $prompt,
        ]);

        try {
            $suggestions = $client->getMacronutrientSuggestions($prompt, $this->formatMessagesForAi());
        } catch (AiSuggestionException $e) {
            if ($e->reason === AiSuggestionExceptionReason::NEEDS_CLARIFICATION) {
                $message->clarification = $e->getMessage();
                $message->type = NutriDialogMessageType::CLARIFICATION;
                $message->save();
            }

            throw $e;
        }

        $message->suggestions = array_map(fn ($suggestion) => $suggestion->toArray(), $suggestions->toArray());
        $message->save();
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
