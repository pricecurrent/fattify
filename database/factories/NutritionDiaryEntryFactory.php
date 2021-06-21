<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Model;
use App\Models\NutritionDiaryEntry;
use App\Models\NutritoinDiaryEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

class NutritionDiaryEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NutritionDiaryEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'date' => today(),
            'fat' => 10,
            'carbohydrates' => 30,
            'protein' => 20,
            'meal_time' => 'breakfast',
            'calorie' => 300,
            'dish_name' => 'chicken',
        ];
    }
}
