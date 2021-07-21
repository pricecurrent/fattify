<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pricecurrent\LaravelEloquentFilters\Filterable;

class NutritionDiaryEntry extends Model
{
    use HasFactory;
    use Filterable;

    /**
     * Don't protect against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['date'];
}
