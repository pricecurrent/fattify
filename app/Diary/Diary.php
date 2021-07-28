<?php

namespace App\Diary;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bookmark;
use App\Diary\Macronutrients;
use App\Models\NutritionDiaryEntry;

class Diary
{
    protected $user;
    protected $date;

    public function __construct(
        protected DiaryEntryFactory $entryFactory
    ) {}

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
        return $this->entryFactory
            ->withUser($this->user)
            ->withDate($this->date)
            ->write(
                macronutrients: $macronutrients,
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
            ->write($macronutrientsEatenBasedOnWeight, dishName: $bookmark->name, mealTime: $mealTime);

        $bookmark->bumpUsage();

        return $entry;
    }
}
