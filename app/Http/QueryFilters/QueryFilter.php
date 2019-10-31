<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class QueryFilter
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Apply the filters to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \ReflectionException
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $parameter) {
            if ( ! method_exists($this, $filter)) {
                continue;
            }

            $reflection = new \ReflectionMethod($this, $filter);
            $requiresParam = (boolean) $reflection->getNumberOfRequiredParameters();

            if (is_null($parameter) && $requiresParam) {
                continue;
            }

            is_null($parameter) ? $this->$filter() : $this->$filter($parameter);
        }

        return $this->builder;
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        return request()->all();
    }

    /**
     * Guess the filter name for the given class.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return string
     */
    public static function guessFilterName(Model $model): string
    {
        return 'App\\Http\\QueryFilters\\'.class_basename($model).'Filters';
    }
}
