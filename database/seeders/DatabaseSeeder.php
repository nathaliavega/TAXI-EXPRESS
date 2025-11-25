<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Eliminar usuario de prueba si existe
        User::where('email', 'test@example.com')->delete();
        
        // Eliminar usuario admin si existe para recrearlo
        User::where('email', 'elder.garcia@gmail.com')->delete();
        
        // Crear usuario administrador
        User::create([
            'name' => 'Elder García',
            'email' => 'elder.garcia@gmail.com',
            'password' => Hash::make('elder123'), // Encripta la contraseña
            'id_rol' => 1, // Asegúrate que este campo existe en tu tabla
            'activo' => true, // Asegúrate que este campo existe en tu tabla
        ]);
        
        echo "✅ Usuario admin creado: elder.garcia@gmail.com\n";
        echo "🔑 Contraseña: elder123\n";
    }
}