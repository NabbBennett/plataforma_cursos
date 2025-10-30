<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Controlador del correo
    |--------------------------------------------------------------------------
    |
    | Laravel soporta varios "drivers" para enviar correos. Para Google
    | Workspace (Gmail) usa 'smtp'.
    |
    */

    'default' => env('MAIL_MAILER', 'smtp'),

    /*
    |--------------------------------------------------------------------------
    | Configuraciones del servidor SMTP
    |--------------------------------------------------------------------------
    */

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => env('MAIL_EHLO_DOMAIN', null),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Dirección global de envío
    |--------------------------------------------------------------------------
    |
    | Dirección y nombre que aparecerán como remitente por defecto.
    |
    */

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'no-responder@tudominio.com'),
        'name' => env('MAIL_FROM_NAME', env('APP_NAME')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración Markdown para correos
    |--------------------------------------------------------------------------
    */

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
