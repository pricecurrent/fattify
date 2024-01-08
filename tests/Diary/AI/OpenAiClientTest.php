<?php

namespace Tests\Diary\AI;

use App\Diary\AI\AiSuggestionException;
use App\Diary\AI\OpenAiClient;
use App\Models\NutriDialog;
use App\Models\NutriDialogMessage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @group api
 */
class OpenAiClientTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_builds_suggestions()
    {
        $client = resolve(OpenAiClient::class);

        $suggestions = $client->getMacronutrientSuggestions('I ate 100 grams of chicken breast and rice weighted 200 grams uncooked');

        $this->assertCount(2, $suggestions);
        $this->assertStringContainsString('chicken breast', $suggestions[0]->name);
        $this->assertStringContainsString('rice', $suggestions[1]->name);
    }

    /** @test */
    public function it_builds_suggestions_based_on_the_previous_messages()
    {
        $client = resolve(OpenAiClient::class);
        $dialog = NutriDialog::factory()->create();
        $message = NutriDialogMessage::factory()->for($dialog)->create([
            'prompt' => 'I ate 100 grams of chicken breast and rice weighted 200 grams uncooked',
            'suggestions' => ['foods' => [
                ["name" => "chicken breast", "carbs" => 0, "fats" => 3, "proteins" => 31],
                ["name" => "rice", "carbs" => 148, "fats" => 1, "proteins" => 13],
            ]]
        ]);
        $messages = $dialog->formatMessagesForAi();

        $suggestions = $client->getMacronutrientSuggestions('There were 15 grams of proteins in rice', $messages);

        $this->assertCount(2, $suggestions);
        $this->assertStringContainsString('chicken breast', $suggestions[0]->name);
        $this->assertStringContainsString('rice', $suggestions[1]->name);
        $this->assertEquals(15, $suggestions[1]->proteins);
    }

    /** @test */
    public function it_handles_nonesence()
    {
        $client = resolve(OpenAiClient::class);

        try {
            $suggestions = $client->getMacronutrientSuggestions('the colors are red, the trees are blue');
        } catch (AiSuggestionException $e) {
            $this->assertTrue(true);

            return;
        }

        $this->fail('No exception thrown on gibberish');
    }
}
