<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class BeerFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('beers.name', 'LIKE', '%'.$search.'%');
    }

    public function style(string $search): Builder
    {
        return $this->builder->whereHas('style', function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }

    public function brewery(string $search): Builder
    {
        return $this->builder->whereHas('brewery', function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }

    public function color(string $search): Builder
    {
        return $this->builder->whereHas('color', function ($query) use ($search) {
            $query->where('name', 'LIKE', '%'.$search.'%');
        });
    }
}