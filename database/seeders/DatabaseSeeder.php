<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Eliminar usuario admin si existe
        DB::table('usuarios')->where('correo', 'elder.garcia@gmail.com')->delete();
        
        // Crear usuario administrador
        DB::table('usuarios')->insert([
            'nombre' => 'Elder García',
            'correo' => 'elder.garcia@gmail.com',
            'contrasena' => Hash::make('elder123'),
            'id_rol' => 1,
            'activo' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "✅ Usuario admin creado en tabla 'usuarios'\n";
        echo "📧 Email: elder.garcia@gmail.com\n";
        echo "🔑 Contraseña: elder123\n";
    }
}