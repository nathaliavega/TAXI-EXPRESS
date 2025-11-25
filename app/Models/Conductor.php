<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    protected $table = 'conductores';
    protected $primaryKey = 'id_conductor';
    
    public $timestamps = false; // Si tu tabla no tiene created_at/updated_at
    
    protected $fillable = [
        'id_usuario', // ✅ Campo que relaciona con usuarios
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'tipo_documento',
        'numero_documento',
        'telefono',
        'celular',
        'email',
        'licencia',
        'categoria',
        'estado',
    ];

    // ✅ Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    // ✅ Obtener nombre completo
    public function getNombreCompletoAttribute()
    {
        return trim(
            ($this->primer_nombre ?? '') . ' ' . 
            ($this->segundo_nombre ?? '') . ' ' . 
            ($this->primer_apellido ?? '') . ' ' . 
            ($this->segundo_apellido ?? '')
        );
    }
}