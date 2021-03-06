<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\BillingProfile;
use Faker\Generator as Faker;

$factory->define(BillingProfile::class, function (Faker $faker) {
    return [
        'business_name' => $faker->company,
        'route' => $faker->streetName . ', ' . $faker->buildingNumber,
        'postal_code' => $faker->postcode,
        'city' => $faker->city,
        'district' => $faker->randomElement([
            'AG', 'AL', 'AN', 'AO', 'AR', 'AP', 'AT', 'AV', 'BA', 'BT', 'BL',
            'BN', 'BG', 'BI', 'BO', 'BZ', 'BS', 'BR', 'CA', 'CL', 'CB', 'CI',
            'CE', 'CT', 'CZ', 'CH', 'CO', 'CS', 'CR', 'KR', 'CN', 'EN', 'FM',
            'FE', 'FI', 'FG', 'FC', 'FR', 'GE', 'GO', 'GR', 'IM', 'IS', 'SP',
            'AQ', 'LT', 'LE', 'LC', 'LI', 'LO', 'LU', 'MC', 'MN', 'MS', 'MT',
            'ME', 'MI', 'MO', 'MB', 'NA', 'NO', 'NU', 'OT', 'OR', 'PD', 'PA',
            'PR', 'PV', 'PG', 'PU', 'PE', 'PC', 'PI', 'PT', 'PN', 'PZ', 'PO',
            'RG', 'RA', 'RC', 'RE', 'RI', 'RN', 'RM', 'RO', 'SA', 'VS', 'SS',
            'SV', 'SI', 'SR', 'SO', 'TA', 'TE', 'TR', 'TO', 'OG', 'TP', 'TN',
            'TV', 'TS', 'UD', 'VA', 'VE', 'VB', 'VC', 'VR', 'VV', 'VI', 'VT',
        ]),
        'country' => 'Italia',
        'vat_number' => $faker->regexify('[0-9]{11}'),
        'pec' => $faker->companyEmail,
        'sdi' => $faker->regexify('[a-zA-Z0-9]{6}')
    ];
});
