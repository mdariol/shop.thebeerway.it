<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Price;
use Faker\Generator as Faker;

$factory->define(Price::class, function (Faker $faker) {
    return [
        'beer_id' => function () {
            return factory(App\Beer::class)->create();
        },

        'horeca' => $faker->numberBetween(80, 140),
        'purchase' => $faker->numberBetween(80, 140),
        'distribution' => $faker->numberBetween(80, 140),

        'discount' => $faker->numberBetween(0, 99),
        'margin' => $faker->numberBetween(5, 95),
        'fixed_margin' => $faker->boolean,
    ];
});
