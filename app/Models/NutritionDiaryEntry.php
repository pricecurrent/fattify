<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionDiaryEntry extends Model
{
    use HasFactory;

    /**
     * Don't protect against mass assignment.
     *
     * @var array
     */
    protected $guarded = [];

    protected $dates = ['date', 'bookmarked_at'];
}
