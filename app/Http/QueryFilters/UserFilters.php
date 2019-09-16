<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class UserFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('users.name', 'ILIKE', "%$search%");
    }

    public function email(string $search): Builder
    {
        return $this->builder->where('users.email', 'ILIKE', "%$search%");
    }

    public function role(string $search): Builder
    {
        return $this->builder->whereHas('roles', function ($query) use ($search) {
            return $query->where('id', $search);
        });
    }
}
