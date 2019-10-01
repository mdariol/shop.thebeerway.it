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
        return $this->builder->where('total_amount', '>=', $search);
    }

    public function total_amount_to(string $search): Builder
    {
        return $this->builder->where('total_amount', '=<', $search);
    }

    public function brewery_id(string $search): Builder
    {
        return $this->builder->whereExists( function ($query) use ($search) {
            $query->select('lines.id')
                ->from('lines')
                ->join('beers','lines.beer_id','=','beers.id')
                ->whereRaw('lines.order_id = orders.id and beers.brewery_id='.$search);
        });
    }

//select number from orders where exists (select lines.id from lines join beers on (lines.beer_id = beers.
//id) where beers.brewery_id=4 and lines.order_id = orders.id)

    public function date_from(string $search): Builder
    {
        return $this->builder->where('date', '>=', $search);
    }

    public function date_to(string $search): Builder
    {
        return $this->builder->where('date', '<=', $search);
    }


}
