<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ShippingAddress;
use Faker\Generator as Faker;

$factory->define(ShippingAddress::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'company_id' => function () {
            return factory(App\Company::class)->create();
        }
    ];
});
