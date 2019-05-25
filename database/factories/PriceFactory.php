<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Price;
use Faker\Generator as Faker;

$factory->define(Price::class, function (Faker $faker) {
    return [
        'beer_id' => function () {
            return factory(App\Beer::class)->create();
        },

        'horeca' => $faker->numberBetween(100, 10000),
        'purchase' => $faker->numberBetween(100, 10000),
        'distribution' => $faker->numberBetween(100, 10000),

        'horeca_unit' => $faker->numberBetween(100, 10000),
        'purchase_unit' => $faker->numberBetween(100, 10000),
        'distribution_unit' => $faker->numberBetween(100, 10000),

        'discount' => $faker->numberBetween(0, 99),
        'margin' => $faker->numberBetween(5, 95),
        'fixed_margin' => $faker->boolean
    ];
});
