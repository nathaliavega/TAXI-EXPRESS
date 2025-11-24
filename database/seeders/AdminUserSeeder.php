<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nombre' => 'Elder',
            'apellido' => 'Garcia',
            'correo' => 'elder.garcia@gmail.com',
            'contrasena' => Hash::make('elder123'), // Cambia esta contraseña
            'id_rol' => 1,
            'activo' => 1,
        ]);

        echo "Usuario administrador creado exitosamente\n";
    }
}