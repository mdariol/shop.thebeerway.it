<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'billing_profile_id' => factory(\App\BillingProfile::class)->create()->id,
        'shipping_address_id' => factory(\App\ShippingAddress::class)->create()->id,
        'policy_id' => factory(\App\Policy::class)->create()->id,
        'state' => 'sent',
    ];
});

$factory->afterCreatingState(Order::class, 'with_lines', function (Order $order, $faker) {
    factory(\App\Line::class)->create(['order_id' => $order->id]);
});

$factory->state(Order::class, 'cart', ['state' => 'draft']);
