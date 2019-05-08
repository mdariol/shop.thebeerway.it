<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Beer;
use Faker\Generator as Faker;

$factory->define(Beer::class, function (Faker $faker) {
    return [
        'brewery_id' => function () {
            return factory(App\Brewery::class)->create();
        },
        'packaging_id' => function () {
            return factory(App\Packaging::class)->create();
        }
    ];
});
