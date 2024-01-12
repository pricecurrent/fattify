<?php

namespace Tests\Models;

use App\Diary\AI\AiSuggestionException;
use App\Diary\AI\NutriDialogMessageType;
use App\Diary\AI\OpenAiClient;
use App\Models\NutriDialog;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NutriDialogTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /** @test */
    public function assistant_asks_for_clarifications_when_needed_to_answer_user_prompt()
    {
        $prompt = 'I ate chicken';

        $dialog = NutriDialog::factory()->create();
        $ai = $this->mock(OpenAiClient::class);
        $ai->shouldReceive('getMacronutrientSuggestions')
            ->with($prompt, [])
            ->once()
            ->andThrow(AiSuggestionException::needsClarification(
                $clarification = 'Please specify the amount of chicken'
            ));

        try {
            $dialog->ask($prompt, $ai);
        } catch (AiSuggestionException) {
            $this->assertCount(1, $dialog->fresh()->messages);
            $message = $dialog->fresh()->messages()->first();
            $this->assertEquals($prompt, $message->prompt);
            $this->assertEmpty($message->suggestions);
            $this->assertSame($clarification, $message->clarification);
            $this->assertEquals(NutriDialogMessageType::CLARIFICATION, $message->type);

            return;
        }

        $this->fail('Expected AiSuggestionException to be thrown');
    }

    /** @test */
    public function it_throws_exception_when_not_able_to_handle_user_prompt()
    {
        $prompt = 'I ate chicken';

        $dialog = NutriDialog::factory()->create();
        $ai = $this->mock(OpenAiClient::class);
        $ai->shouldReceive('getMacronutrientSuggestions')
            ->with($prompt, [])
            ->once()
            ->andThrow(AiSuggestionException::invalidPrompt('invalid'));

        try {
            $dialog->ask($prompt, $ai);
        } catch (AiSuggestionException) {
            $this->assertCount(0, $dialog->fresh()->messages);

            return;
        }

        $this->fail('Expected AiSuggestionException to be thrown');
    }
}
