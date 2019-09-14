<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class CompanyFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('companies.business_name', 'ILIKE', "%$search%");
    }

    public function owner(string $search): Builder
    {
        return $this->builder->where('companies.owner_id', $search);
    }

    public function state(string $search): Builder
    {
        return $this->builder->where('state', $search);
    }
}
