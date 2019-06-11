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
        foreach ($this->filters() as $method => $parameter) {
            if ( ! method_exists($this, $method)) {
                continue;
            }

            $reflection = new \ReflectionMethod($this, $method);

            $hasParam = (boolean) $reflection->getNumberOfParameters();
            $requiresParam = (boolean) $reflection->getNumberOfRequiredParameters();

            if ( ! empty($parameter) && ($requiresParam || $hasParam)) {
                $this->$method($parameter);
            }

            if (empty($parameter) && (! $requiresParam || ! $hasParam)) {
                $this->$method();
            }
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