<?php

namespace Tests\Http\Controllers\Api;

use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserNutritionDiaryEntriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     */
    public function it_cant_see_diary_entries_if_not_logged_in()
    {
        $this->json('get', route('api.user-nutrition-diary-entries.get', $this->user))->assertUnauthorized();
    }

    /**
     * @test
     */
    public function it_cant_see_other_person_entries()
    {
        $evilBitch = User::factory()->create();
        $this
            ->actingAs($evilBitch)
            ->json('get', route('api.user-nutrition-diary-entries.get', $this->user))
            ->assertForbidden();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserNutritionDiaryEntriesController::index
     */
    public function it_lists_user_diary_entries()
    {
        NutritionDiaryEntry::factory()->create(['user_id' => $this->user->id, 'calorie' => 500]);

        $response = $this
            ->actingAs($this->user)
            ->json('get', route('api.user-nutrition-diary-entries.get', ['user' => $this->user]));

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Api\UserNutritionDiaryEntriesController::index
     */
    public function it_lists_user_diary_entries_filtered_by_date()
    {
        $entryA = NutritionDiaryEntry::factory()->create(['dish_name' => 'Carrot', 'user_id' => $this->user->id, 'date' => today()->subDay()]);
        $entryB = NutritionDiaryEntry::factory()->create(['dish_name' => 'Potato', 'user_id' => $this->user->id, 'date' => today()]);

        $response = $this
            ->actingAs($this->user)
            ->json('get', route('api.user-nutrition-diary-entries.get', ['user' => $this->user]), [
                'date' => today(),
            ]);

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
        $response->assertJsonHasModel($entryB);
        $response->assertJsonDoesntHaveModel($entryA);
    }
}
