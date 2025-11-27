<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioMantenimiento extends Model
{
    protected $table = 'servicio_mantenimiento';
    protected $primaryKey = 'id_mantenimiento';
    public $timestamps = false;

    protected $fillable = [
        'id_vehiculo',
        'id_mantenimiento_general',
        'fecha_mantenimiento',
        'costo',
        'taller',
        'descripcion',
        'realizado_por',
        'factura',
        'observaciones'
    ];

    protected $casts = [
        'fecha_mantenimiento' => 'date',
        'costo' => 'decimal:2',
    ];

    // Relación con Vehículo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo');
    }

    // Relación con Mantenimiento General (tipo de mantenimiento)
    public function mantenimientoGeneral()
    {
        return $this->belongsTo(MantenimientoGeneral::class, 'id_mantenimiento_general', 'id_mantenimiento_general');
    }
}