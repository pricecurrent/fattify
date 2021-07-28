<?php

namespace App\Diary;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bookmark;
use App\Models\NutritionDiaryEntry;
use App\Diary\WriteToDiaryException;

class DiaryEntryFactory
{
    protected $user;
    protected $date;
    protected $madeFromBookmark;

    public function __construct(protected CaloriesCalculator $caloriesCalculator) {}

    public function write(Macronutrients $macronutrients, ?string $dishName = null, ?string $mealTime = null): NutritionDiaryEntry
    {
        $this->guardCanWrite();

        return NutritionDiaryEntry::create([
            'user_id' => $this->user->id,
            'date' => $this->date,
            'calorie' => $this->caloriesCalculator->calculate($macronutrients),
            'carbohydrates' => $macronutrients->carbs,
            'protein' => $macronutrients->proteins,
            'fat' => $macronutrients->fats,
            'meal_time' => $mealTime ?? 'other',
            'dish_name' => $dishName ?? null,
            'made_from_bookmark_id' => $this->madeFromBookmark?->id,
        ]);
    }

    public function withUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function withDate(Carbon $date)
    {
        $this->date = $date;
        return $this;
    }

    public function setMadeFromBookmark(Bookmark $bookmark)
    {
        $this->madeFromBookmark = $bookmark;
        return $this;
    }

    protected function guardCanWrite()
    {
        if (! $this->user || ! $this->date) {
            throw new WriteToDiaryException('Can not write to diary without user or date provided');
        }
    }
}
