<?php

namespace Tests\Diary;

use App\Diary\CaloriesCalculator;
use App\Diary\Macronutrients;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CaloriesCalculatorTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers \App\Diary\CaloriesCalculator::calculate
     */
    public function it_calculates_calories_out_of_macronutrients()
    {
        $macros = new Macronutrients([
            'carbs' => 30,
            'proteins' => 33,
            'fats' => 40,
        ]);

        $calories = resolve(CaloriesCalculator::class)->calculate($macros);

        $this->assertEquals(
            (30 * 4) + (33 * 4) + (40 * 9),
            $calories
        );
    }

    /**
     * @test
     * @covers \App\Diary\CaloriesCalculator::calculate
     */
    public function it_calculates_calories_when_one_of_the_macros_is_not_provided()
    {
        $macros = new Macronutrients([
            'carbs' => 30,
            'proteins' => 33,
        ]);

        $calories = resolve(CaloriesCalculator::class)->calculate($macros);

        $this->assertEquals(
            (30 * 4) + (33 * 4),
            $calories
        );
    }
}
