<?php

return [
    'approval' => [
        'graph' => 'approval',
        'property_path' => 'state',
        'class' => \App\Company::class,
        'states' => [
            'approval',
            'approved',
            'rejected',
        ],
        'transitions' => [
            'approve' => [
                'from' => ['approval', 'rejected'],
                'to' => 'approved'
            ],
            'reject' => [
                'from' => ['approval', 'approved'],
                'to' => 'rejected'
            ]
        ],
    ],

    'orderflow' => [
        'graph' => 'orderflow',
        'property_path' => 'state',
        'class' => \App\Order::class,
        'states' => [
            'draft',
            'sent',
            'confirmed',
            'shipped',
            'canceled',
        ],
        'transitions' => [
            'send' => [
                'from' => ['draft', 'canceled'],
                'to' => 'sent'
            ],
            'confirm' => [
                'from' => ['sent', 'canceled'],
                'to' => 'confirmed'
            ],
            'ship' => [
                'from' => ['confirmed', 'sent', 'canceled'],
                'to' => 'shipped'
            ],
            'cancel' => [
                'from' => ['sent', 'confirmed'],
                'to' => 'canceled'
            ],
            'canceledtodraft' => [
                'from' => ['canceled'],
                'to' => 'draft'
            ],
        ],
    ],



];
