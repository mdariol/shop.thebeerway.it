<?php

return [
    'approval' => [
        'graph' => 'approval',
        'property_path' => 'state',
        'class' => \App\BillingProfile::class,
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
                'from' => ['draft'],
                'to' => 'sent'
            ],
            'confirm' => [
                'from' => ['sent'],
                'to' => 'confirmed'
            ],
            'ship' => [
                'from' => ['confirmed', 'sent'],
                'to' => 'shipped'
            ],
            'cancel' => [
                'from' => ['sent', 'confirmed'],
                'to' => 'canceled'
            ],
            'reset' => [
                'from' => ['canceled'],
                'to' => 'draft'
            ],
        ],
    ],
];
