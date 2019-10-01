<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class OrderFilters extends QueryFilter
{
    public function number(string $search): Builder
    {
        return $this->builder->where('number', 'ILIKE', "%$search%");
    }

    public function state(string $search): Builder
    {
        return $this->builder->where('state', $search);
    }

    public function owner(string $search): Builder
    {
        return $this->builder->whereHas('user', function ($query) use ($search) {
            $query->where('name', 'ILIKE', "%$search%");
        });
    }

    public function company(string $search): Builder
    {
        return $this->builder->whereHas('company', function ($query) use ($search) {
            $query->where('business_name', 'ILIKE', "%$search%");
        });
    }

    public function total_amount_from(string $search): Builder
    {
        return $this->builder->where('total_amount', '>', $search);
    }

    public function total_amount_to(string $search): Builder
    {
        return $this->builder->where('total_amount', '<', $search);
    }
}
