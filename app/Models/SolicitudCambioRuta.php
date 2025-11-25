<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCambioRuta extends Model
{
    protected $table = 'solicitudes_cambio_ruta';
    protected $primaryKey = 'id_solicitud';
    
    public $timestamps = false; // Tu tabla no tiene created_at/updated_at
    
    protected $fillable = [
        'id_conductor',
        'id_vehiculo',
        'id_tarifa_destino',
        'fecha_solicitud',
        'fecha_viaje_programada',
        'nombre_contratante',
        'documento_contratante',
        'telefono_contratante',
        'direccion_origen',
        'direccion_destino',
        'numero_pasajeros',
        'autorizado_por',
        'fecha_autorizacion',
        'fecha_inicio_real',
        'fecha_fin_real',
        'tarifa_cobrada',
        'estado',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_viaje_programada' => 'datetime',
        'fecha_autorizacion' => 'datetime',
        'fecha_inicio_real' => 'datetime',
        'fecha_fin_real' => 'datetime',
        'tarifa_cobrada' => 'decimal:2',
        'numero_pasajeros' => 'integer',
    ];

    // Relaciones
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'id_conductor', 'id_conductor');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo');
    }

    public function tarifaDestino()
    {
        return $this->belongsTo(TarifaDestino::class, 'id_tarifa_destino', 'id_tarifa');
    }

    public function autorizadoPor()
    {
        return $this->belongsTo(Usuario::class, 'autorizado_por', 'id_usuario');
    }
}