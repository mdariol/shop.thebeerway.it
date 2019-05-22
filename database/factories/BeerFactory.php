<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Beer;
use Faker\Generator as Faker;

$factory->define(Beer::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->randomDigit,
        'name' => $faker->randomElement(['Apollo', 'Whale', 'Winternest']),
        'description' => $faker->paragraph,
        'abv' => $faker->numberBetween(2, 14),
        'ibu' => $faker->numberBetween(2, 14),
        'plato' => $faker->numberBetween(2, 14),
        'brewery_id' => function () {
            return factory(App\Brewery::class)->create();
        },
        'packaging_id' => function () {
            return factory(App\Packaging::class)->create();
        },
        'style_id' => function () {
            return factory(App\Style::class)->create();
        },
        'price_id' => function () {
        return factory(App\Price::class)->create();
        }
    ];
});
