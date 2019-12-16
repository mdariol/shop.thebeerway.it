<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class LotFilters extends QueryFilter
{
    /**
     * Filter by number.
     *
     * @param  string  $search
     * @return Builder
     */
    public function number(string $search): Builder
    {
        return $this->builder->where('name', 'ILIKE', "%$search%");
    }

    /**
     * Filter by beer relation.
     *
     * @param  array  $search
     * @return Builder
     */
    public function beer(array $search): Builder
    {
        return $this->builder->whereHas('beer', function (Builder $query) use ($search) {
            $query->where('id', array_shift($search));

            foreach ($search as $id) {
                $query->orWhere('id', $id);
            }
        });
    }

    /**
     * Filter by brewery relation.
     *
     * @param  array  $search
     * @return Builder
     */
    public function brewery(array $search): Builder
    {
        return $this->builder->whereHas('beer', function (Builder $query) use ($search) {
            $query->whereHas('brewery', function (Builder $query) use ($search) {
                $query->where('id', array_shift($search));

                foreach ($search as $id) {
                    $query->orWhere('id', $id);
                }
            });
        });
    }

    /**
     * Filter by expires_at.
     *
     * @param  string  $search
     * @return Builder
     */
    public function expiring_at(string $search): Builder
    {
        return $this->builder->whereDate('expires_at', '<=', $search);
    }
}
