<?php

namespace App\Transformers;

use App\Models\NutritionDiaryEntry;
use League\Fractal\TransformerAbstract;

class NutritionDiaryEntryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(NutritionDiaryEntry $entry)
    {
        return [
            'id' => $entry->id,
            'calories' => $entry->calorie,
            'fats' => $entry->fat,
            'carbs' => $entry->carbohydrates,
            'proteins' => $entry->protein,
            'dishName' => $entry->dish_name,
            'mealTime' => $entry->meal_time,
        ];
    }
}
