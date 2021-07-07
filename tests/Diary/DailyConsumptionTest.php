<?php

namespace Tests\Diary;

use App\Diary\DailyConsumption;
use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DailyConsumptionTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * @test
     * @covers \DailyConsumption::handle
     */
    public function it_calcualtes_daily_consumption_for_a_user_on_a_specific_date()
    {
        $date = today();
        $this->user->update(['daily_calories_goal' => 20]);
        NutritionDiaryEntry::factory()->create([
            'user_id' => $this->user->id,
            'fat' => 1,
            'carbohydrates' => 1,
            'protein' => 1,
            'calorie' => 17
        ]);

        $consumption = (new DailyConsumption($this->user))->onDate($date)->get();

        $this->assertEquals(1, $consumption->fats);
        $this->assertEquals(1, $consumption->proteins);
        $this->assertEquals(1, $consumption->carbs);
        $this->assertEquals(17, $consumption->calories);
        $this->assertEquals(0.85, $consumption->percentage);
        $this->assertEquals(53, $consumption->fatsPercentage);
        $this->assertEquals(24, $consumption->carbsPercentage);
        $this->assertEquals(24, $consumption->proteinsPercentage);
    }

    /**
     * @test
     * @covers \DailyConsumption::handle
     */
    public function it_calcualtes_daily_consumption_when_there_is_none()
    {
        $date = today();
        $this->user->update(['daily_calories_goal' => 20]);

        $consumption = (new DailyConsumption($this->user))->onDate($date)->get();

        $this->assertEquals(0, $consumption->fats);
        $this->assertEquals(0, $consumption->proteins);
        $this->assertEquals(0, $consumption->carbs);
        $this->assertEquals(0, $consumption->calories);
        $this->assertEquals(0, $consumption->percentage);
        $this->assertEquals(0, $consumption->fatsPercentage);
        $this->assertEquals(0, $consumption->carbsPercentage);
        $this->assertEquals(0, $consumption->proteinsPercentage);
    }
}
