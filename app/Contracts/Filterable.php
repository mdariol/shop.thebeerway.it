<?php

namespace App\Contracts;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

interface Filterable
{
    public function scopeFilter($filters, QueryFilter $query_filter): Builder;
}