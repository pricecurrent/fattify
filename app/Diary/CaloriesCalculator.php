<?php

namespace App\Diary;

class CaloriesCalculator
{
    public function calculate(Macronutrients $macronutrients)
    {
        return $macronutrients->carbs * 4 + $macronutrients->proteins * 4 + $macronutrients->fats * 9;
    }
}
