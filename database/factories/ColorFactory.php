<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Area;
use App\Color;
use Faker\Generator as Faker;

$factory->define(Color::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->colorName,
    ];
});


