<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model
{
    use HasFactory;

    
    protected $table = 'propietarios';

    
    protected $primaryKey = 'id_propietario';

    
    public $timestamps = false;

    
    protected $fillable = [
        'razon_social',
        'nit',
        'representante_legal',
        'activo',
        'fecha_registro'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_registro' => 'datetime',
    ];

   
    protected $attributes = [
        'activo' => true,
    ];

    
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_propietario', 'id_propietario');
    }

    
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeInactivos($query)
    {
        return $query->where('activo', false);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function ($q) use ($termino) {
            $q->where('razon_social', 'ILIKE', "%{$termino}%")
              ->orWhere('nit', 'ILIKE', "%{$termino}%")
              ->orWhere('representante_legal', 'ILIKE', "%{$termino}%");
        });
    }
}