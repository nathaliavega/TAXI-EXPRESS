<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Eliminar usuario admin si existe
        User::where('correo', 'elder.garcia@gmail.com')->delete();
        
        // Crear usuario administrador con campos correctos
        User::create([
            'name' => 'Elder García',
            'correo' => 'elder.garcia@gmail.com',  // ⚠️ Usar 'correo'
            'contrasena' => Hash::make('elder123'), // ⚠️ Usar 'contrasena'
            'id_rol' => 1,
            'activo' => true,
        ]);
        
        echo "✅ Usuario admin creado\n";
        echo "📧 Email: elder.garcia@gmail.com\n";
        echo "🔑 Contraseña: elder123\n";
    }
}