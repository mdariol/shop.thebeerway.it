<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class BeerFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('beers.name', 'ILIKE', '%'.$search.'%');
    }

    public function stock(string $search): Builder
    {
        if ($search =='on') {
            return $this->builder->whereRaw('beers.stock - beers.requested_stock > 0');
        } else
        {
            return $this->builder;
        }
    }
    public function style(array $search): Builder
    {
        return $this->builder->whereHas('style', function ($query) use ($search) {
            $this->wherebuilder($search, $query);
        });
    }

    public function brewery(array $search): Builder
    {
        return $this->builder->whereHas('brewery', function ($query) use ($search) {
            $this->wherebuilder($search, $query);
        });
    }

    public function color(array $search): Builder
    {
        return $this->builder->whereHas('color', function ($query) use ($search) {
            $this->wherebuilder($search, $query);
        });
    }

    public function taste(array $search): Builder
    {
        return $this->builder->whereHas('taste', function ($query) use ($search) {
            $this->wherebuilder($search, $query);
        });
    }

    public function packaging(string $search): Builder
    {
        return $this->builder->whereHas('packaging', function ($query) use ($search) {
           $query->where('type', '=', $search);
        });
    }

    protected function wherebuilder($search, $query ){

        foreach ($search as $key => $string) {
            if ($key == 0) {
                $query->where('name', 'ILIKE', '%'.$string.'%');
            } else {
                $query->orwhere('name', 'ILIKE', '%'.$string.'%');
            }
        }

    }
}