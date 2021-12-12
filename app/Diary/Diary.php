<?php

namespace App\Diary;

use App\Models\Bookmark;
use App\Models\NutritionDiaryEntry;
use App\Models\User;
use Carbon\Carbon;

class Diary
{
    protected $user;
    protected $date;

    public function __construct(
        protected DiaryEntryFactory $entryFactory
    ) {
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

    public function writeMacronutrients(Macronutrients $macronutrients, int $weight, $mealTime = null, $dishName = null)
    {
        $macronutrientsEatenBasedOnWeight = new Macronutrients([
            'fats' => $macronutrients->fats * $weight / 100,
            'carbs' => $macronutrients->carbs * $weight / 100,
            'proteins' => $macronutrients->proteins * $weight / 100,
        ]);

        return $this->entryFactory
            ->withUser($this->user)
            ->withDate($this->date)
            ->setWeight($weight)
            ->write(
                macronutrients: $macronutrientsEatenBasedOnWeight,
                mealTime: $mealTime,
                dishName: $dishName
            );
    }

    public function writeFromBookmark(Bookmark $bookmark, int $weight, ?string $mealTime = null): NutritionDiaryEntry
    {
        $macronutrientsEatenBasedOnWeight = new Macronutrients([
            'fats' => $bookmark->fats * $weight / 100,
            'carbs' => $bookmark->carbs * $weight / 100,
            'proteins' => $bookmark->proteins * $weight / 100,
        ]);

        $entry = $this->entryFactory
            ->withDate($this->date)
            ->withUser($this->user)
            ->setMadeFromBookmark($bookmark)
            ->setWeight($weight)
            ->write($macronutrientsEatenBasedOnWeight, dishName: $bookmark->name, mealTime: $mealTime);

        $bookmark->bumpUsage();

        return $entry;
    }
}
