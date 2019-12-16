<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class BeerFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('beers.name', 'ILIKE', "%$search%");
    }

    public function stock(bool $search): Builder
    {
        return $this->builder->whereHas('lots', function ($query) {
            $query->whereRaw('stock - reserved > 0');
        });
    }

    public function style(array $search): Builder
    {
        return $this->builder->whereHas('style', function ($query) use ($search) {
            $first = array_shift($search);

            $query->where('name', 'ILIKE', "%$first%");

            foreach ($search as $string) {
                $query->orWhere('name', 'ILIKE', "%$string%");
            }
        });
    }

    public function brewery(array $search): Builder
    {
        return $this->builder->whereHas('brewery', function ($query) use ($search) {
            $first = array_shift($search);

            $query->where('name', 'ILIKE', "%$first%");

            foreach ($search as $string) {
                $query->orWhere('name', 'ILIKE', "%$string%");
            }
        });
    }

    public function color(array $search): Builder
    {
        return $this->builder->whereHas('color', function ($query) use ($search) {
            $first = array_shift($search);

            $query->where('name', 'ILIKE', "%$first%");

            foreach ($search as $string) {
                $query->orWhere('name', 'ILIKE', "%$string%");
            }
        });
    }

    public function taste(array $search): Builder
    {
        return $this->builder->whereHas('taste', function ($query) use ($search) {
            $first = array_shift($search);

            $query->where('name', 'ILIKE', "%$first%");

            foreach ($search as $string) {
                $query->orWhere('name', 'ILIKE', "%$string%");
            }
        });
    }

    public function packaging(string $search): Builder
    {
        return $this->builder->whereHas('packaging', function ($query) use ($search) {
           $query->where('type', $search);
        });
    }
}
