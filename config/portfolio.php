<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Credenciales del administrador (usadas por AdminUserSeeder)
    |--------------------------------------------------------------------------
    |
    | Se leen desde config (y no con env() directo en el seeder) para que
    | sigan funcionando cuando la configuración está cacheada con
    | `php artisan config:cache` — en ese caso env() devuelve null.
    |
    */

    'admin_name' => env('ADMIN_NAME', 'Admin'),
    'admin_email' => env('ADMIN_EMAIL'),
    'admin_password' => env('ADMIN_PASSWORD'),

];
