<?php

namespace App\Traits;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    public function scopeFilter($filters, QueryFilter $query_filter): Builder
    {
        return $query_filter->apply($filters);
    }
}