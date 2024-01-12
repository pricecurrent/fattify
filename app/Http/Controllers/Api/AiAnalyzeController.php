<?php

namespace App\Http\Controllers\Api;

use App\Diary\AI\AiSuggestionException;
use App\Diary\AI\AiSuggestionExceptionReason;
use App\Diary\AI\OpenAiClient;
use App\Models\NutriDialog;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AiAnalyzeController
{
    public function __invoke(OpenAiClient $client, Request $request)
    {
        $request->validate(['prompt' => ['string', 'required']]);

        $dialog = NutriDialog::retrieve($request->dialog_id);

        try {
            $message = $dialog->ask($request->prompt, $client);
        } catch (AiSuggestionException $e) {
            if ($e->reason === AiSuggestionExceptionReason::INVALID_PROMPT) {
                throw ValidationException::withMessages(['prompt' => [$e->getMessage()]]);
            }
        }

        return redirect()
            ->back()
            ->withCookie('dialog_id', $dialog->id)
            ->with('success', 'View your nutritional breakdown below.');
    }
}
