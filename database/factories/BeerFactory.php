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
            return factory(App\Color::class)->create()->id;
        },

        'taste_id' => function () {
            return factory(App\Taste::class)->create()->id;
        },

        'brewery_id' => function () {
            return factory(App\Brewery::class)->create()->id;
        },

        'packaging_id' => function () {
            return factory(App\Packaging::class)->create()->id;
        },

        'style_id' => function () {
            return factory(App\Style::class)->create()->id;
        },
    ];
});

$factory->afterCreating(Beer::class, function (Beer $beer) {
    factory(\App\Price::class)->create(['beer_id' => $beer->id]);
});

$factory->afterCreatingState(Beer::class, 'available', function (Beer $beer) {
    factory(\App\Lot::class)->state('available')->create([
        'beer_id' => $beer->id,
    ]);
});

$factory->afterCreatingState(Beer::class, 'unavailable', function (Beer $beer) {
    factory(\App\Lot::class)->state('unavailable')->create([
        'beer_id' => $beer->id,
    ]);
});
