<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class BreweryFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('breweries.name', 'ILIKE', "%$search%");
    }

}
