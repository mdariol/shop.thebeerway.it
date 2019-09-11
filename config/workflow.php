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
];
