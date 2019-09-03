<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'business_name' => $faker->company,
        'address' => $faker->address,
        'vat_number' => $faker->regexify('[0-9]{11}'),
        'pec' => $faker->companyEmail,
        'sdi' => $faker->regexify('[a-zA-Z0-9]{6}')
    ];
});
