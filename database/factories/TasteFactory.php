<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Taste;
use Faker\Generator as Faker;

$factory->define(Taste::class, function (Faker $faker) {
    return ['name' => $faker->name];
});
