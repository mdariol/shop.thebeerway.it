<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Brewery;
use Faker\Generator as Faker;

$factory->define(Brewery::class, function (Faker $faker) {

    $isactive = true;

    return [
        'name' => $faker->company
    ];
});
