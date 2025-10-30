<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Disco predeterminado
    |--------------------------------------------------------------------------
    |
    | Este valor determina el sistema de archivos predeterminado que usará
    | tu aplicación. El "local" es una opción adecuada para desarrollo.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Discos de sistema de archivos
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar múltiples "discos", incluso para diferentes
    | servicios cloud como S3, Google Drive, etc.
    |
    */

    'disks' => [

        'google' => [
        'driver' => 'google',
        'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
        'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
        'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
        'folderId' => env('GOOGLE_DRIVE_FOLDER_ID'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enlaces simbólicos
    |--------------------------------------------------------------------------
    |
    | Cuando ejecutes el comando `storage:link`, Laravel creará estos
    | enlaces para que los archivos sean accesibles públicamente.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
