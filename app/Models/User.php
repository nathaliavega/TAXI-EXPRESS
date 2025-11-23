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
        'apellido',
        'correo',
        'contrasena',
        'id_rol',
        'activo'
    ];

 
    protected $hidden = [
        'contrasena',
    ];

    
    public $timestamps = false;

  
    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

   
    public function getPasswordAttribute()
    {
        return $this->contrasena;
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    
    public function getNombreRolAttribute()
    {
      
        $rolesMap = [
            1 => 'admin',
            2 => 'operadora',
            3 => 'conductor',
            4 => 'conductor',
            5 => 'conductor',
            6 => 'conductor',
            7 => 'conductor',
            8 => 'conductor',
            9 => 'conductor',
            10 => 'conductor',
            11 => 'conductor',
            12 => 'conductor',
        ];

        return $rolesMap[$this->attributes['id_rol']] ?? 'conductor';
    }

    
    public function esAdministrador()
    {
        return $this->id_rol === 1;
    }


    public function esOperadora()
    {
        return $this->id_rol === 2;
    }

    public function esConductor()
    {
        return $this->id_rol >= 3;
    }
}