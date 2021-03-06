<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Packaging;
use Faker\Generator as Faker;

$factory->define(Packaging::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(Packaging::TYPE),
        'quantity' => $faker->randomElement([1, 12, 24]),
        'capacity' => $faker->randomElement([2400, 2000, 75, 33])
    ];
});
