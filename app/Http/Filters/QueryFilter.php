<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws \ReflectionException
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if ( ! method_exists($this, $name)) {
                continue;
            }

            $required = (boolean) (new \ReflectionMethod($this, $name))->getNumberOfRequiredParameters();

            if ($required && empty($value)) {
                continue;
            }

            empty($value) ? $this->$name() : $this->$name($value);
        }

        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }
}