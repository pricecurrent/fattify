<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Modules\Sales\Infrastructure\PostCutoffChanges\SkipOrderPostCutoffService;

class DiaryControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers App\Http\Controllers\DiaryController
     */
    public function guests_can_not_access_diary()
    {
        $this->json('get', 'diary')->assertStatus(401);
    }

    /**
     * @test
     * @covers App\Http\Controllers\DiaryController
     */
    public function it_shows_a_diary()
    {
        $user = User::factory()->create([
            'daily_calories_goal' => 2400,
        ]);

        $response = $this->actingAs($user)->json('get', 'diary');

        $response->assertInertia(function (Assert $page) {
            $page->component('Diary')
                ->where('date', now()->format('F d, Y'))
                ->where('dailyCaloriesGoal', 2400);
        });
    }
}
