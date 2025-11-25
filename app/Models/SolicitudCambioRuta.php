<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitudCambioRuta extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_cambio_ruta';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;

    protected $fillable = [
        'id_conductor',
        'id_tarifa_actual',
        'id_tarifa_solicitada',
        'motivo',
        'estado',
        'fecha_solicitud',
        'fecha_respuesta',
        'respuesta_admin'
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_respuesta' => 'datetime'
    ];

    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'id_conductor', 'id_conductor');
    }

    public function tarifaActual()
    {
        return $this->belongsTo(TarifaDestino::class, 'id_tarifa_actual', 'id_tarifa');
    }

    public function tarifaSolicitada()
    {
        return $this->belongsTo(TarifaDestino::class, 'id_tarifa_solicitada', 'id_tarifa');
    }
}