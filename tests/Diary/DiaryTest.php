<?php

namespace Tests\Diary;

use Tests\TestCase;
use App\Diary\Diary;
use App\Models\User;
use App\Models\Bookmark;
use App\Diary\Macronutrients;
use App\Models\NutritionDiaryEntry;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DiaryTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->date = today();
    }

    /**
     * @test
     * @covers \App\Diary\Diary::writeMacronutrients
     */
    public function it_writes_an_entry_from_macronutrients_per_100_g_and_weight()
    {
        $macronutrients = new Macronutrients([
            'fats' => 10,
            'carbs' => 30,
            'proteins' => 4,
        ]);
        $weight = 50;
        $diary = resolve(Diary::class)->forUser($this->user)->onDate($this->date);

        $entry = $diary->writeMacronutrients($macronutrients, weight: $weight, dishName: 'Banana', mealTime: 'dinner');

        $this->assertCount(1, NutritionDiaryEntry::all());
        $this->assertSame($entry->user_id, $this->user->id);
        $this->assertCarbon($entry->date, $this->date);
        $this->assertTrue($entry->is(NutritionDiaryEntry::first()));
        $this->assertSame(5, $entry->fat);
        $this->assertSame(15, $entry->carbohydrates);
        $this->assertSame(2, $entry->protein);
        $this->assertSame(2 * 4 + 15 * 4 + 5 * 9, $entry->calorie);
        $this->assertSame('Banana', $entry->dish_name);
        $this->assertSame('dinner', $entry->meal_time);
        $this->assertNull($entry->made_from_bookmark_id);
        $this->assertSame(50, $entry->weight);

    }

    /**
     * @test
     * @covers App\Diary\Diary::writeFromBookmark
     */
    public function it_writes_entry_from_a_bookmark()
    {
        $this->assertCount(0, NutritionDiaryEntry::all());
        $diary = resolve(Diary::class)->forUser($this->user)->onDate($this->date);
        $bookmark = Bookmark::factory()->create([
            'name' => 'Cheddar',
            'fats' => 30,
            'carbs' => 0,
            'proteins' => 25,
        ]);
        $weight = 30;

        $entry = $diary->writeFromBookmark($bookmark, $weight);

        $this->assertCount(1, NutritionDiaryEntry::all());
        $this->assertSame($entry->user_id, $this->user->id);
        $this->assertCarbon($entry->date, $this->date);
        $this->assertTrue($entry->is(NutritionDiaryEntry::first()));
        $this->assertSame(9, $entry->fat);
        $this->assertSame(0, $entry->carbohydrates);
        // 100g => 25[p]
        // 30g => x[p]
        // x = 7.5
        $this->assertSame(7.5, $entry->protein);
        $this->assertSame(7.5 * 4 + 9 * 9, $entry->calorie);
        $this->assertSame('Cheddar', $entry->dish_name);
        $this->assertSame('other', $entry->meal_time);
        $this->assertSame($bookmark->id, $entry->made_from_bookmark_id);
        $this->assertSame(1, $bookmark->fresh()->used_times_count);
        $this->assertCarbon(now(), $bookmark->fresh()->last_used_at);
        $this->assertSame(30, $entry->weight);
    }
}
