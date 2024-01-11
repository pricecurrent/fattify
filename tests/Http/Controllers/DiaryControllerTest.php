<?php

namespace Tests\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DiaryControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers \App\Http\Controllers\DiaryController
     */
    public function guests_can_not_access_diary()
    {
        $this->json('get', 'diary')->assertStatus(401);
    }

    /**
     * @test
     * @covers \App\Http\Controllers\DiaryController
     */
    public function it_shows_a_diary()
    {
        $user = User::factory()->create([
            'daily_calories_goal' => 2400,
        ]);

        $response = $this->actingAs($user)->json('get', 'diary');

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Diary')
                ->where('date', now()->format('F d, Y'))
                ->where('dailyCaloriesGoal', 2400);
        });
    }
}
