<?php

namespace App\Transformers;

use App\Models\NutritionDiaryEntry;
use League\Fractal\TransformerAbstract;

class NutritionDiaryEntryTransformer extends TransformerAbstract
{
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
            'weight' => $entry->weight,
            'fats' => $entry->fat,
            'carbs' => $entry->carbohydrates,
            'proteins' => $entry->protein,
            'dishName' => $entry->dish_name,
            'mealTime' => $entry->meal_time,
            'isMadeFromBookmark' => (bool) $entry->made_from_bookmark_id,
            'bookmarkedAt' => $entry->bookmarked_at?->toDateTimeString(),
        ];
    }
}
