<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Lot;
use Faker\Generator as Faker;

$factory->define(Lot::class, function (Faker $faker) {

    $bottled_at = \Carbon\Carbon::now()->subDays(rand(1, 90));

    return [
        'number' => $faker->regexify('[A-Za-z0-9]{7}'),
        'beer_id' => factory(App\Beer::class)->create()->id,
        'stock' => $faker->randomNumber(1),
        'reserved' => $faker->randomNumber(1),
        'bottled_at' => $bottled_at,
        'expires_at' => $bottled_at->copy()->addMonths(rand(4, 8)),
    ];
});

$factory->state(Lot::class, 'available', [
    'stock' => 5,
    'reserved' => 0,
]);

$factory->state(Lot::class, 'unavailable', [
    'stock' => 5,
    'reserved' => 5,
]);
