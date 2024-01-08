<?php

namespace Tests\Http\Controllers\Api;

use App\Diary\AI\OpenAiClient;
use App\Diary\Macronutrients;
use App\Models\NutriDialog;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AiAnalyzeControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_analyzes_free_input_and_makes_a_suggestion()
    {
        $prompt = 'I ate 100 grams of chicken breast and rice weighted 200 grams uncooked';
        $user = User::factory()->create([]);
        $this->mock(OpenAiClient::class)
            ->shouldReceive('getMacronutrientSuggestions')
            ->with($prompt, [])
            ->once()
            ->andReturn(collect([Macronutrients::fake(['name' => 'chicken breast']), Macronutrients::fake(['name' => 'carrot'])]));

        $response = $this->actingAs($user)->from('diary')->postJson(route('api.analyze'), [
            'prompt' => $prompt,
        ]);

        $response->assertRedirect(route('diary'));

        $this->assertCount(1, $user->nutriDialogs);
        $dialog = $user->nutriDialogs->first();
        $this->assertCount(1, $dialog->messages);
        $message = $dialog->messages->first();
        $this->assertEquals($prompt, $message->prompt);
        $this->assertCount(2, $message->suggestions);
        $this->assertEquals($user->id, $dialog->user_id);
        // assert the food is contained within the suggestions
        $this->assertEquals('chicken breast', $message->suggestions[0]['name']);
        $this->assertEquals('carrot', $message->suggestions[1]['name']);
    }

    /** @test */
    public function it_adds_suggestion_to_existing_dialog()
    {
        $prompt = 'I ate 100 grams of chicken breast and rice weighted 200 grams uncooked';
        $user = User::factory()->create();
        $dialog = NutriDialog::factory()->for($user)->hasMessages(3)->create();
        $this->mock(OpenAiClient::class)
            ->shouldReceive('getMacronutrientSuggestions')
            ->with($prompt, $dialog->formatMessagesForAi())
            ->once()
            ->andReturn(collect([Macronutrients::fake(['name' => 'chicken breast']), Macronutrients::fake(['name' => 'carrot'])]));

        $response = $this->actingAs($user)->from('diary')->postJson(route('api.analyze'), [
            'dialog_id' => $dialog->uuid,
            'prompt' => $prompt,
        ]);

        $response->assertRedirect(route('diary'));

        $this->assertCount(1, $user->nutriDialogs);
        $dialog = $user->nutriDialogs->first();
        $this->assertCount(4, $dialog->messages);
        $message = $dialog->messages->last();
        $this->assertEquals($prompt, $message->prompt);
        $this->assertCount(2, $message->suggestions);
        $this->assertEquals($user->id, $dialog->user_id);
        // assert the food is contained within the suggestions
        $this->assertEquals('chicken breast', $message->suggestions[0]['name']);
        $this->assertEquals('carrot', $message->suggestions[1]['name']);
    }
}
