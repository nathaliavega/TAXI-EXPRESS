<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TurnoObligatorio extends Model
{
    use HasFactory;

    protected $table = 'turnos_obligatorios';
    protected $primaryKey = 'id_turno';
    
    // Deshabilitar timestamps automáticos de Laravel (created_at, updated_at)
    public $timestamps = false;

    // Indicar que fecha_asignacion es un campo de fecha que Laravel debe manejar
    const CREATED_AT = 'fecha_asignacion';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_vehiculo',
        'id_conductor',
        'fecha_turno',
        'estado',
        'asignado_por',
        'fecha_asignacion'
    ];

    // Convertir automáticamente estos campos a objetos Carbon
    protected $casts = [
        'fecha_turno' => 'date',
        'fecha_asignacion' => 'datetime',
        'id_vehiculo' => 'integer',
        'id_conductor' => 'integer',
        'asignado_por' => 'integer'
    ];

    // Valores por defecto
    protected $attributes = [
        'estado' => 'programado'
    ];

    // Boot method para establecer fecha_asignacion automáticamente al crear
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($turno) {
            if (empty($turno->fecha_asignacion)) {
                $turno->fecha_asignacion = now();
            }
        });

        // 🔥 SOLUCIÓN: Sincronizar la secuencia después de crear un turno
        static::created(function ($turno) {
            try {
                DB::statement("SELECT setval('turnos_obligatorios_id_turno_seq', 
                    (SELECT COALESCE(MAX(id_turno), 0) FROM turnos_obligatorios))");
            } catch (\Exception $e) {
                \Log::warning('No se pudo sincronizar la secuencia: ' . $e->getMessage());
            }
        });
    }

    // Relación con Vehiculo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo', 'id_vehiculo');
    }

    // Relación con Conductor
    public function conductor()
    {
        return $this->belongsTo(Conductor::class, 'id_conductor', 'id_conductor');
    }

    // Relación con Usuario (quien asignó)
    public function asignadoPor()
    {
        return $this->belongsTo(User::class, 'asignado_por', 'id_usuario');
    }

    // Scope para filtrar por estado
    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    // Scope para turnos futuros
    public function scopeFuturos($query)
    {
        return $query->where('fecha_turno', '>=', now()->toDateString());
    }

    // Scope para turnos pasados
    public function scopePasados($query)
    {
        return $query->where('fecha_turno', '<', now()->toDateString());
    }

    // Scope para turnos de hoy
    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_turno', today());
    }

    // Scope para turnos por vehículo
    public function scopePorVehiculo($query, $idVehiculo)
    {
        return $query->where('id_vehiculo', $idVehiculo);
    }

    // Scope para turnos por conductor
    public function scopePorConductor($query, $idConductor)
    {
        return $query->where('id_conductor', $idConductor);
    }
}