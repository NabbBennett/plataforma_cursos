<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Servicios de terceros
    |--------------------------------------------------------------------------
    |
    | Este archivo es para almacenar las credenciales de servicios como
    | Stripe, Mercado Pago, Google, y otros. Puedes acceder a esto
    | desde config('services.nombre_del_servicio').
    |
    */

    // Ejemplo de integración con Mercado Pago
    'mercadopago' => [
        'access_token' => env('MP_ACCESS_TOKEN'),
    ],

    // Si más adelante usas Google Drive para subir grabaciones
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'refresh_token' => env('GOOGLE_REFRESH_TOKEN'),
        'folder_id' => env('GOOGLE_DRIVE_FOLDER_ID'),
    ],

    // Ejemplo: integración con Mailgun (no estás usando esto, pero se deja por defecto)
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    // Ejemplo: integración con AWS SES (no lo necesitas si usas Gmail/Workspace)
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Stripe por defecto (puedes quitarlo si no lo usas)
    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
    ],

];
