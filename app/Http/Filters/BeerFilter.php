<?php

namespace App\Http\Filters;

class BeerFilter extends QueryFilter
{
    public function name(string $search = null)
    {
        if ( ! $search) {
            return $this->builder;
        }

        return $this->builder->where('name', 'LIKE', '%'.$search.'%');
    }
}