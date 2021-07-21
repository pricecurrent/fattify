<?php

namespace App\Models;

use App\Diary\Macronutrients;
use Facades\App\Diary\CaloriesCalculator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    /**
     * Don't protect against mass assignment
     * @var array
     */
    protected $guarded = [];

    public static function createFromEntry(NutritionDiaryEntry $entry, User $user, int $weight, string $name)
    {
        $macronutrientsIn100g = new Macronutrients([
            'fats' => $entry->fat * 100 / $weight,
            'carbs' => $entry->carbohydrates * 100 / $weight,
            'proteins' => $entry->protein * 100 / $weight,
        ]);

        return static::create([
            'user_id' => $user->id,
            'name' => $name,
            'calories' => CaloriesCalculator::calculate($macronutrientsIn100g),
            'fats' => $macronutrientsIn100g->fats,
            'carbs' => $macronutrientsIn100g->carbs,
            'proteins' => $macronutrientsIn100g->proteins,
        ]);
    }
}
