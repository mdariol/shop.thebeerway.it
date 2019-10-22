<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class BillingProfileFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('billing_profiles.name', 'ILIKE', "%$search%");
    }

    public function owner(string $search): Builder
    {
        return $this->builder->where('billing_profiles.owner_id', $search);
    }

    public function state(string $search): Builder
    {
        return $this->builder->where('state', $search);
    }
}
