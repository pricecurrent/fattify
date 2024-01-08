<?php

namespace App\Http\Controllers\Api;

use App\Diary\AI\AiSuggestionException;
use App\Diary\AI\OpenAiClient;
use App\Models\NutriDialog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AiAnalyzeController
{
    public function __invoke(OpenAiClient $client, Request $request)
    {
        $request->validate(['prompt' => ['string', 'required']]);

        $dialog = $request->input('dialog_id')
            ? NutriDialog::whereUuid($request->input('dialog_id'))->firstOrFail()
            : NutriDialog::create([
                'uuid' => Str::uuid()->toString(),
                'user_id' => auth()->user()->id,
            ]);

        try {
            $message = $dialog->prompt($request->prompt, $client);
        } catch (AiSuggestionException $e) {
            throw ValidationException::withMessages(['prompt' => [$e->getMessage()]]);
        }

        return redirect()->back()->withCookie('dialog_id', $dialog->id);
    }
}
