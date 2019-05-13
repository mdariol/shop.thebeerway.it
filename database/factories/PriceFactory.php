<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Price;
use Faker\Generator as Faker;

$factory->define(Price::class, function (Faker $faker) {
    return [
        'beer_id' => function () {
            return factory(App\Beer::class)->create();
        },
        'purchase_price' => $faker->numberBetween(100, 10000),
        'purchase_unit_price' => '',
    ];
});
