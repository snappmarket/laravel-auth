<?php

return [
    'baseUrl' => env('SM_AUTH_COMMUNICATOR_URL'),
    'client' => env('SM_AUTH_COMMUNICATOR_CLIENT'),
    'gateway' => [
        'parameters' => [
            'identifier' => 'user_id',
            'key' => 'secret-token'
        ],
        'secret_key' => 'AAJrv%r@2iL279nYf1r&Mht5rs'
    ]
];
