<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class OrderFilters extends QueryFilter
{
    public function state(string $search): Builder
    {
        return $this->builder->where('state', $search);
    }

    public function total_amount(string $search): Builder
    {
        return $this->builder->where('total_amount', '>', $search);
    }

}
