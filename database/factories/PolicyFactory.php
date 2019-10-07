<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Policy;
use Faker\Generator as Faker;

$factory->define(Policy::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(Policy::POLICYNAME),
        'content' => $faker->sentence,
        'from_date' => $faker->date(\Carbon\Carbon::yesterday()),
    ];
});
