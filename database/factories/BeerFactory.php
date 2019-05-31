<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Beer;
use Faker\Generator as Faker;

$factory->define(Beer::class, function (Faker $faker) {
    return [
        'code' => $faker->numberBetween(1000000000, 9999999999),
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'abv' => $faker->numberBetween(2, 14),
        'ibu' => $faker->numberBetween(2, 14),
        'plato' => $faker->numberBetween(2, 14),
        'stock' => $faker->numberBetween(-7, 12),
        'color_id' => function () {
            return factory(App\Color::class)->create();
        },
        'brewery_id' => function () {
            return factory(App\Brewery::class)->create();
        },
        'packaging_id' => function () {
            return factory(App\Packaging::class)->create();
        },
        'style_id' => function () {
            return factory(App\Style::class)->create();
        },
    ];
});
