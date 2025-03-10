<?php

return [
    'api_service' => [
        'url' => rtrim(env('API_SERVICE_URL', ''), '/'),
        'token' => env('API_SERVICE_TOKEN'),
    ],
];
