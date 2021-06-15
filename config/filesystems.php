<?php

return [
    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'cloud'   => env('FILESYSTEM_CLOUD', 's3'),
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'uploads' => [
            'driver' => 'local',
            'root' => storage_path('app/public/uploads'),
            'url' => env('APP_URL').'/storage/uploads',
            'visibility' => 'public',
        ],
        'files' => [
            'driver' => 'local',
            'root' => storage_path('app/public/files'),
            'url' => env('APP_URL').'/storage/files',
            'visibility' => 'public',
        ],
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],


        'api-usuarios' => [
            'driver' => 'local',
            'root'   => storage_path('../public/usuarios/api'),
        ],

        'api-colores' => [
            'driver' => 'local',
            'root'   => storage_path('../public/colores/api'),
        ],

        'api-telas' => [
            'driver' => 'local',
            'root'   => storage_path('../public/telas/api'),
        ],
    ],
];
