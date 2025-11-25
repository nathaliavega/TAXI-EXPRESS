<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
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
        'email_verified_at' => 'datetime',
        'activo' => 'boolean',
    ];

    // ✅ CRÍTICO: Decirle a Laravel qué campo usar para la contraseña
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // ✅ Para recuperación de contraseña
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    // ✅ Opcional: Para poder usar $user->email en tu código
    public function getEmailAttribute()
    {
        return $this->correo;
    }
}