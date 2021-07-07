<?php

namespace Tests\Http\Controllers\Diary;

use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CaloriesDiaryEntriesControllerTest extends TestCase
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
    public function guest_cant_write_calories()
    {
        $response = $this->json('post', route('nutrition-diary-entries.calories.store'), [
            'calories' => '100',
        ])->assertUnauthorized();
    }

    /**
     * @test
     * @covers \App\Http\Controllers\Diary\CaloriesDiaryEntriesController::store
     */
    public function it_writes_calories()
    {
        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.calories.store'), [
            'calories' => '100',
            'dish_name' => 'chicken',
            'meal_time' => 'breakfast',
            'date' => today()->subDay()->format('l, F d, Y'),
        ]);

        $response->assertRedirect(route('diary'));
        $this->assertEquals(1, NutritionDiaryEntry::count());
        $this->assertEquals(1, $this->user->nutritionDiaryEntries()->count());
        $entry = NutritionDiaryEntry::first();
        $this->assertEquals(100, $entry->calorie);
        $this->assertEquals(today()->subDay()->toDateString(), $entry->date->toDateString());
        $this->assertEquals('breakfast', $entry->meal_time);
        $this->assertEquals('chicken', $entry->dish_name);
    }

    /**
     * @test
     * @covers \CaloriesDiaryEntriesController::handle
     */
    public function it_uses_todays_date_if_cant_understdand_whats_passed_in()
    {
        $response = $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.calories.store'), [
            'calories' => '100',
            'date' => null,
        ]);

        $response->assertRedirect(route('diary'));
        $this->assertEquals(1, NutritionDiaryEntry::count());
        $this->assertEquals(1, $this->user->nutritionDiaryEntries()->count());
        $entry = NutritionDiaryEntry::first();
        $this->assertEquals(100, $entry->calorie);
        $this->assertEquals(today()->toDateString(), $entry->date->toDateString());
    }

    /**
     * @test
     * @covers \CaloriesDiaryEntriesController::handle
     */
    public function calories_must_be_positive_integer()
    {
        $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.calories.store'), [
            'calories' => 'foo',
        ])->assertStatus(422);

        $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.calories.store'), [
            'calories' => 0
        ])->assertStatus(422);

        $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.calories.store'), [
            'calories' => -30
        ])->assertStatus(422);
    }

    /**
     * @test
     * @covers \CaloriesDiaryEntriesController::handle
     */
    public function meal_time_should_be_known()
    {
        $this->actingAs($this->user)->json('post', route('nutrition-diary-entries.calories.store'), [
            'calories' => '100',
            'meal_time' => 'nNN',
        ])->assertStatus(422);
    }
}
