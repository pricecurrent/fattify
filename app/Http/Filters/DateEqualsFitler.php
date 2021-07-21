<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractQueryFilter;

class DateEqualsFitler extends AbstractQueryFilter
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereDate('date', '=', $this->date);
    }

    public function isApplicable(): bool
    {
        return null !== $this->date;
    }
}
