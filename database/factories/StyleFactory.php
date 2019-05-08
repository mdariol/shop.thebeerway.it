<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Style;
use Faker\Generator as Faker;

$factory->define(Style::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Altbier', 'Amber Ale', 'Barley wine',
          'Berliner Weisse', 'Bière de Garde', 'Bitter', 'Blonde Ale', 'Bock',
          'Brown Ale', 'California Common', 'Cream Ale', 'Dopplebock', 'Dunkel',
          'Dunkel Weizen', 'Eisbock', 'Summer Ale', 'Gose', 'Helles', 'India Pale Ale',
          'Kölsch', 'Lambic', 'Light Ale', 'Helles Bock', 'Malt liquor', 'Mild',
          'Marzen', 'Old Ale', 'American Pale Ale', 'Pilsner', 'Porter', 'Red Ale',
          'Saison', 'Scotch Ale', 'Stout', 'Schwarzbier', 'Weisse']),
        'area' => $faker->country
    ];
});
