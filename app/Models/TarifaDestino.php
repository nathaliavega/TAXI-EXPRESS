<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifaDestino extends Model
{
    protected $table = 'tarifas_destino'; // o el nombre de tu tabla

    protected $fillable = [
        'nombre_destino',
        'ciudad',
        'departamento',
        'tarifa_base',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'tarifa_base' => 'decimal:2'
    ];
}