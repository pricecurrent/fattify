<?php

namespace App\Models;

use App\Diary\Macronutrients;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Facades\App\Diary\CaloriesCalculator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookmark extends Model
{
    use HasFactory;

    /**
     * Don't protect against mass assignment
     * @var array
     */
    protected $guarded = [];

    protected $dates = [
        'last_used_at',
    ];

    public static function createFromEntry(NutritionDiaryEntry $entry, User $user, string $name)
    {
        $macronutrientsIn100g = new Macronutrients([
            'fats' => $entry->fat * 100 / $entry->weight,
            'carbs' => $entry->carbohydrates * 100 / $entry->weight,
            'proteins' => $entry->protein * 100 / $entry->weight,
        ]);

        return DB::transaction(function () use ($entry, $user, $name, $macronutrientsIn100g) {
            $entry->update(['bookmarked_at' => now()]);
            return static::create([
                'user_id' => $user->id,
                'name' => $name,
                'calories' => CaloriesCalculator::calculate($macronutrientsIn100g),
                'fats' => $macronutrientsIn100g->fats,
                'carbs' => $macronutrientsIn100g->carbs,
                'proteins' => $macronutrientsIn100g->proteins,
            ]);

        });
    }

    public function bumpUsage()
    {
        $this->update([
            'last_used_at' => now(),
            'used_times_count' => $this->used_times_count + 1,
        ]);
    }
}
