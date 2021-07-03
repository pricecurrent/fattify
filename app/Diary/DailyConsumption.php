<?php

namespace App\Diary;

use Carbon\Carbon;
use App\Models\User;
use App\Models\NutritionDiaryEntry;

class DailyConsumption
{
    protected $user;
    protected $date;

    public $calories;
    public $fats;
    public $carbs;
    public $proteins;
    public $percentage;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function for(User $user)
    {
        return new static($user);
    }

    public function onDate(Carbon $date)
    {
        $this->date = $date;
        return $this;
    }

    public function get()
    {
        $consolidatedEntry = NutritionDiaryEntry::query()
            ->selectRaw('SUM(calorie) as calories')
            ->selectRaw('SUM(protein) as proteins')
            ->selectRaw('SUM(fat) as fats')
            ->selectRaw('SUM(carbohydrates) as carbs')
            ->where('user_id', $this->user->id)
            ->where('date', $this->date->toDateString())
            ->first();

        $this->mapData($consolidatedEntry);

        return $this;
    }

    protected function mapData(NutritionDiaryEntry $consolidatedEntry)
    {
        $this->calories = (int) $consolidatedEntry->calories;
        $this->fats = (int) $consolidatedEntry->fats;
        $this->carbs = (int) $consolidatedEntry->carbs;
        $this->proteins = (int) $consolidatedEntry->proteins;
        $this->percentage = $this->calculatePercentage();
    }

    protected function calculatePercentage()
    {
        if (! $this->user->daily_calories_goal) {
            return null;
        }

        return round($this->calories / $this->user->daily_calories_goal, 2);
    }
}
