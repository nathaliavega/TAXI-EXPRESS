<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifaDestino extends Model
{
    // Especifica el nombre REAL de tu tabla
    protected $table = 'tarifas_destinos';
    
    // Especifica la clave primaria correcta
    protected $primaryKey = 'id_tarifa';
      // ✅ IMPORTANTE: Indicar que es autoincremental
    public $incrementing = true;
    
    // ✅ Indicar el tipo de la clave primaria
    protected $keyType = 'int';

    public $timestamps = false;
    
    protected $attributes = [
        'estado' => 'Activa'
    ];
    
    // Los campos que se pueden llenar
    protected $fillable = [
        'nombre_destino',
        'ciudad',
        'departamento',
        'tarifa_base',
        'fecha_vigencia_desde',
        'fecha_vigencia_hasta',
        'activa'
    ];

    // Convertir automáticamente estos campos
    protected $casts = [
        'tarifa_base' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];
}