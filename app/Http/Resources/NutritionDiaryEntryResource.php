<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NutritionDiaryEntryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'calories' => $this->calorie,
            'weight' => $this->weight,
            'fats' => $this->fat,
            'carbs' => $this->carbohydrates,
            'proteins' => $this->protein,
            'dishName' => $this->dish_name,
            'mealTime' => $this->meal_time,
            'isMadeFromBookmark' => (bool) $this->made_from_bookmark_id,
            'bookmarkedAt' => $this->bookmarked_at?->toDateTimeString(),
        ];
    }
}
