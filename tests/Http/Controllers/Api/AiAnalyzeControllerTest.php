<?php

namespace Tests\Http\Controllers\Api;

use App\Diary\AI\OpenAiClient;
use App\Diary\Macronutrients;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AiAnalyzeControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_analyzes_free_input()
    {
        $prompt = 'I ate 100 grams of chicken breast and rice weighted 200 grams uncooked';
        $user = User::factory()->create([]);
        $this->mock(OpenAiClient::class)
            ->shouldReceive('getMacronutrientValues')
            ->with($prompt)
            ->once()
            ->andReturn(collect([Macronutrients::fake(), Macronutrients::fake()]));

        $response = $this->actingAs($user)->postJson(route('api.analyze'), [
            'prompt' => $prompt,
        ]);

        $response->assertSuccessful();
        $response->assertJsonCount(2);
        $response->assertJsonStructure([
            '*' => [
                'name',
                'carbs',
                'fats',
                'proteins',
            ],
        ]);
    }
}
