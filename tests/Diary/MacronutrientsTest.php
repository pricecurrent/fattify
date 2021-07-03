<?php

namespace Tests\Diary;

use App\Diary\InvalidMacronutrientException;
use App\Diary\Macronutrients;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MacronutrientsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers \App\Diary\Macronutrients::construct
     * @covers \App\Diary\Macronutrients::__get
     */
    public function it_does_some_fancy_thing_needing_its_own_test()
    {
        try {
            $macros = new Macronutrients(['carbs' => 30, 'proteins' => 33, 'foo' => 30]);
        } catch (InvalidMacronutrientException $e) {
            $this->assertTrue(true);

            return;
        }

        $this->fail('InvalidMacronutrientException was not thrown even though it should have had to');
    }
}
