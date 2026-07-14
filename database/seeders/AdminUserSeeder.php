<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Crea el usuario administrador a partir de config/portfolio.php
     * (variables ADMIN_NAME / ADMIN_EMAIL / ADMIN_PASSWORD del .env).
     *
     * Solo se ejecuta si no existe ningún usuario: así, si el admin cambió
     * su email desde el panel, un re-seed no crea un segundo admin con el
     * email antiguo del .env y la contraseña por defecto.
     */
    public function run(): void
    {
        if (User::count() > 0) {
            return;
        }

        $email = config('portfolio.admin_email');
        $password = config('portfolio.admin_password');

        if (! $email || ! $password) {
            throw new RuntimeException(
                'Define ADMIN_EMAIL y ADMIN_PASSWORD en el .env antes de ejecutar el seeder '
                .'(y si usas config:cache, vuelve a ejecutarlo tras cambiar el .env).'
            );
        }

        User::create([
            'name' => config('portfolio.admin_name'),
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
