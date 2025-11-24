<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordEncryptionSeeder extends Seeder
{
    public function run()
    {
        echo "🔍 Verificando contraseñas...\n";
        
        $users = DB::table('users')->get();
        $encrypted = 0;
        
        foreach ($users as $user) {
            // Si la contraseña NO empieza con $2y$ (bcrypt), encriptarla
            if (!str_starts_with($user->password, '$2y$')) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['password' => Hash::make($user->password)]);
                
                echo "✅ {$user->email} - Encriptada\n";
                $encrypted++;
            }
        }
        
        echo "📊 Total encriptadas: $encrypted\n";
    }
}