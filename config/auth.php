<?php


return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'utilisateurs',
        ],
    ],

    'providers' => [
        'utilisateurs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Utilisateur::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'utilisateurs',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];