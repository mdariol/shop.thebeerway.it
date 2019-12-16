<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Line;
use Faker\Generator as Faker;

$factory->define(Line::class, function (Faker $faker) {
    $beer = factory(\App\Beer::class)->state('available')->create();
    $quantity = $faker->numberBetween(1, 5);

    return [
        'order_id' => factory(\App\Order::class)->create()->id,
        'beer_id' => $beer->id,
        'qty' => $quantity,
        'unit_price' => $beer->price->distribution,
        'price' => $beer->price->distribution * $quantity,
    ];
});
