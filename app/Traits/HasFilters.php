<?php

namespace App\Traits;

use App\Http\QueryFilters\QueryFilter;

trait HasFilters
{
    /**
     * Applies query strings, if any.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeQueryFilter($query)
    {
        $queryFilter = app(QueryFilter::guessFilterName($this));

        return $queryFilter->apply($query);
    }
}