<?php

namespace App\Models;

use App\Diary\Macronutrients;
use Facades\App\Diary\CaloriesCalculator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NutritionDiaryEntry extends Model
{
    use HasFactory;

    /**
     * Don't protect against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
        'bookmarked_at' => 'datetime',
    ];

    public function bookmarkAs(string $name)
    {
        $macronutrientsIn100g = new Macronutrients([
            'fats' => $this->fat * 100 / $this->weight,
            'carbs' => $this->carbohydrates * 100 / $this->weight,
            'proteins' => $this->protein * 100 / $this->weight,
        ]);

        return DB::transaction(function () use ($name, $macronutrientsIn100g) {
            $this->update(['bookmarked_at' => now()]);

            return Bookmark::create([
                'user_id' => $this->user_id,
                'name' => $name,
                'calories' => CaloriesCalculator::calculate($macronutrientsIn100g),
                'fats' => $macronutrientsIn100g->fats,
                'carbs' => $macronutrientsIn100g->carbs,
                'proteins' => $macronutrientsIn100g->proteins,
            ]);
        });
    }
}
