<?php

namespace Tests\Http\Controllers\Diary;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MacronutrientsDiaryEntriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\MacronutrientsDiaryEntriesController::store
     */
    public function guest_cant_write_macros_to_diary()
    {
        $payload = [
            'carbs' => 20,
            'fats' => 10,
            'proteins' => 30,
        ];

        $response = $this
            ->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload)
            ->assertUnauthorized();
    }

    /**
     * @test
     * @covers \MacronutrientsDiaryEntriesController::handle
     */
    public function it_writes_macronutrients_to_a_diary()
    {
        $payload = [
            'carbs' => 20,
            'fats' => 10,
            'proteins' => 30,
        ];

        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload);

        $response->assertRedirect(route('diary'));
        $this->assertEquals(1, $this->user->nutritionDiaryEntries()->count());
        $entry = $this->user->nutritionDiaryEntries()->first();
        $this->assertEquals(290, $entry->calorie);
        $this->assertEquals(20, $entry->carbohydrates);
        $this->assertEquals(10, $entry->fat);
        $this->assertEquals(30, $entry->protein);
    }

    /**
     * @test
     * @covers \MacronutrientsDiaryEntriesController::handle
     */
    public function it_accepts_a_day_where_to_write_for_and_it_accepts_a_meal_time_and_it_accepts_a_dish_name()
    {
        $payload = [
            'carbs' => 20,
            'fats' => 10,
            'proteins' => 30,
            'date' => 'May 21, 2020',
            'meal_time' => 'breakfast',
            'dish_name' => 'chicken',
        ];

        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload);

        $response->assertRedirect(route('diary'));
        $this->assertEquals(1, $this->user->nutritionDiaryEntries()->count());
        $entry = $this->user->nutritionDiaryEntries()->first();
        $this->assertEquals('2020-05-21', $entry->date->toDateString());
        $this->assertEquals('breakfast', $entry->meal_time);
        $this->assertEquals('chicken', $entry->dish_name);
    }

    /**
     * @test
     * @covers \MacronutrientsDiaryEntriesController::handle
     */
    public function at_least_one_macro_is_required()
    {
        $payload = [
            'carbs' => null,
            'fats' => null,
            'proteins' => null,
        ];

        // $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload);

        $response->assertStatus(422);
        $this->assertEquals(0, $this->user->nutritionDiaryEntries()->count());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\MacronutrientsDiaryEntriesController
     */
    public function at_least_one_macro_is_must_be_greater_than_0()
    {
        $payload = [
            'carbs' => 0,
            'fats' => 0,
            'proteins' => 0,
        ];

        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('fats');
        $this->assertEquals(0, $this->user->nutritionDiaryEntries()->count());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\MacronutrientsDiaryEntriesController
     */
    public function macros_can_not_be_negative()
    {
        $payload = [
            'carbs' => 0,
            'fats' => -3,
            'proteins' => 0,
        ];

        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload);

        $response->assertStatus(422);
        $this->assertEquals(0, $this->user->nutritionDiaryEntries()->count());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\MacronutrientsDiaryEntriesController
     */
    public function a_date_must_be_valid()
    {
        $payload = [
            'carbs' => 33,
            'date' => 'not-a-date',
        ];

        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('date');
        $this->assertEquals(0, $this->user->nutritionDiaryEntries()->count());
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\MacronutrientsDiaryEntriesController
     */
    public function meal_time_should_be_known()
    {
        $payload = [
            'carbs' => 33,
            'meal_time' => 'whats this?',
        ];

        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.macronutrients.store'), $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('meal_time');
        $this->assertEquals(0, $this->user->nutritionDiaryEntries()->count());
    }
}
