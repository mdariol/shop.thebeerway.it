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
        return $this->builder->whereHas('owner', function ($query) use ($search) {
            return $query->where('name', 'ILIKE', "%$search%");
        });
    }

    public function state(string $search): Builder
    {
        return $this->builder->where('state', $search);
    }

    public function legal_person(bool $search): Builder
    {
        return $this->builder->where('legal_person', $search);
    }
}
