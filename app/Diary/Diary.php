<?php

namespace App\Diary;

use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Carbon\Carbon;

class Diary
{
    protected $caloriesCalculator;

    public function __construct(CaloriesCalculator $caloriesCalculator)
    {
        $this->caloriesCalculator = $caloriesCalculator;
    }

    public function forUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function onDate(Carbon $date)
    {
        $this->date = $date;

        return $this;
    }

    public function writeMacronutrients(Macronutrients $macronutrients, $mealTime = null, $dishName = null)
    {
        NutritionDiaryEntry::create([
            'user_id' => $this->user->id,
            'date' => $this->date->toDateString(),
            'calorie' => $this->caloriesCalculator->calculate($macronutrients),
            'carbohydrates' => $macronutrients->carbs,
            'protein' => $macronutrients->proteins,
            'fat' => $macronutrients->fats,
            'meal_time' => $mealTime,
            'dish_name' => $dishName,
        ]);
    }
}
