<?php

return [
    'baseUrl' => env('SM_AUTH_COMMUNICATOR_URL'),
    'client' => env('SM_AUTH_COMMUNICATOR_CLIENT'),
    'gateway' => [
        'parameters' => [
            'identifier' => 'user_id',
            'key' => 'secret-token'
        ],
        'secret_key' => env('SM_AUTH_SECRET_KEY')
    ]
];
