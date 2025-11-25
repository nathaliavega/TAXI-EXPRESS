<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'Apellido',
        'correo',
        'contrasena',
        'id_rol',
        'activo',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function getAuthPasswordName()
    {
        return 'contrasena';
    }
}