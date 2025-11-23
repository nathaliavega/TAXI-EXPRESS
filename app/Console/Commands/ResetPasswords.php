<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetPasswords extends Command
{
    protected $signature = 'passwords:reset';
    protected $description = 'Resetea las contraseñas de todos los usuarios según la base de datos';

    public function handle()
    {
        $this->info('🔄 Reseteando contraseñas según base de datos...');
        
      
        $passwords = [
            
            'elder.garcia@gmail.com' => 'elder123',
            'diana.lopez@gmail.com' => 'diana123',
            'juan.martinez@gmail.com' => 'andres123',
            'carlos.rodriguez@gmail.com' => 'carlos123',
            'miguel.gonzalez@gmail.com' => 'miguel123',
            'diego.fernandez@gmail.com' => 'diego123',
            'santiago.lopez@gmail.com' => 'santiago123',
            'sebastian.ramirez@gmail.com' => 'sebastian123',
            'rafael.torres@gmail.com' => 'rafale123',
            'javier.moreno@gmail.com' => 'javiel123',
            'sofia.castillo@gmail.com' => 'sofia123',
            'valentina.herrera@gmail.com' => 'valentina123',
        ];

        foreach ($passwords as $email => $password) {
            DB::table('usuarios')
                ->where('correo', $email)
                ->update([
                    'contrasena' => Hash::make($password)
                ]);
            
            $this->info("✅ {$email} → Contraseña: {$password}");
        }

        $this->newLine();
        $this->info('✅ Todas las contraseñas han sido reseteadas según la base de datos');
        $this->newLine();
        $this->info('📝 Credenciales de acceso:');
        $this->newLine();
        
        $this->info('👨‍💼 ADMINISTRADOR:');
        $this->table(
            ['Correo', 'Contraseña'],
            [
                ['elder.garcia@gmail.com', 'elder123'],
            ]
        );
        
        $this->newLine();
        $this->info('👩‍💼 OPERADORA:');
        $this->table(
            ['Correo', 'Contraseña'],
            [
                ['diana.lopez@gmail.com', 'diana123'],
            ]
        );
        
        $this->newLine();
        $this->info('🚗 CONDUCTORES:');
        $this->table(
            ['Correo', 'Contraseña'],
            [
                ['juan.martinez@gmail.com', 'andres123'],
                ['carlos.rodriguez@gmail.com', 'carlos123'],
                ['miguel.gonzalez@gmail.com', 'miguel123'],
                ['diego.fernandez@gmail.com', 'diego123'],
                ['santiago.lopez@gmail.com', 'santiago123'],
                ['sebastian.ramirez@gmail.com', 'sebastian123'],
                ['rafael.torres@gmail.com', 'rafale123'],
                ['javier.moreno@gmail.com', 'javiel123'],
                ['sofia.castillo@gmail.com', 'sofia123'],
                ['valentina.herrera@gmail.com', 'valentina123'],
            ]
        );
        
        $this->newLine();
        $this->warn('⚠️  NOTA: Estas son las contraseñas definidas en la base de datos SQL.');
        $this->warn('⚠️  Se recomienda que los usuarios cambien sus contraseñas después del primer ingreso.');
    }
}