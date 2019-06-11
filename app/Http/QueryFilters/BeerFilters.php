<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class BeerFilters extends QueryFilter
{
    public function name(string $search): Builder
    {
        return $this->builder->where('beers.name', 'LIKE', '%'.$search.'%');

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

    protected function wherebuilder($search, $query ){

        foreach ($search as $key => $string) {
            if ($key == 0) {
                $query->where('name', 'LIKE', '%'.$string.'%');
            } else {
                $query->orwhere('name', 'LIKE', '%'.$string.'%');
            }
    }

}
}