<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlTurno;
use App\Models\TurnoObligatorio;
use App\Models\Vehiculo;
use App\Models\Conductor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OperadoraController extends Controller
{
    public function dashboard()
    {
        return view('operadora.dashboard');
    }

    public function controlTurnos()
    {
        $controles = ControlTurno::with([
            'turno.vehiculo',
            'turno.conductor'
        ])
       // Descomentar la opción que prefieras:
    ->orderBy('id_control', 'desc')  // Por ID (más recientes primero)
    // ->orderBy('hora_inicio', 'asc')  // Por hora de inicio
    // ->orderByDesc('created_at')  // Por fecha de creación
    ->paginate(20);  // 20 registros por página

    $vehiculos = Vehiculo::select('id_vehiculo as id', 'placa')
        ->where('estado', 'activo')
        ->orderBy('placa')
        ->get();

    $conductores = Conductor::select('id_conductor as id', 'primer_nombre', 'primer_apellido')
        ->where('estado', 'activo')
        ->orderBy('primer_nombre')
        ->get();

    return view('operadora.control-turnos', compact('controles', 'vehiculos', 'conductores'));
        }
    /**
     * Actualizar un control de turno
     */
    public function updateControlTurno(Request $request, $id)
    {
        try {
            // Validar datos
            $validated = $request->validate([
                'vehiculo_id' => 'required|exists:vehiculos,id_vehiculo',
                'conductor_id' => 'required|exists:conductores,id_conductor',
                'nombre_franja' => 'required|in:Turno_noche,Turno_mañana',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i',
                'hora_llamado' => 'required|date_format:H:i',
                'respondio' => 'required|boolean',
                'en_servicio' => 'required|boolean'
            ]);

            DB::beginTransaction();

            // Encontrar el control de turno usando la primary key correcta
            $control = ControlTurno::where('id_control', $id)->firstOrFail();
            
            // Verificar si cambió el vehículo o conductor
            $turno = $control->turno;
            if ($turno->id_vehiculo != $validated['vehiculo_id'] || 
                $turno->id_conductor != $validated['conductor_id']) {
                
                // Buscar un turno existente con el nuevo vehículo/conductor
                $nuevoTurno = TurnoObligatorio::where('id_vehiculo', $validated['vehiculo_id'])
                    ->where('id_conductor', $validated['conductor_id'])
                    ->where('fecha_turno', Carbon::today())
                    ->first();
                
                if ($nuevoTurno) {
                    // Si existe, usar ese turno
                    $control->id_turno = $nuevoTurno->id_turno;
                } else {
                    // Si no existe, mantener el turno actual y solo actualizar sus datos
                    $turno->id_vehiculo = $validated['vehiculo_id'];
                    $turno->id_conductor = $validated['conductor_id'];
                    $turno->save();
                }
            }

            // Determinar si el turno cruza medianoche
            // Comparar las horas: si hora_fin < hora_inicio, cruza medianoche
            $horaInicio = strtotime($validated['hora_inicio']);
            $horaFin = strtotime($validated['hora_fin']);
            $cruzaMedianoche = $horaFin < $horaInicio;

            // Actualizar el control
            $control->nombre_franja = $validated['nombre_franja'];
            $control->hora_inicio = $validated['hora_inicio'];
            $control->hora_fin = $validated['hora_fin'];
            $control->hora_llamado = $validated['hora_llamado'];
            $control->respondio = $validated['respondio'];
            $control->en_servicio = $validated['en_servicio'];
            $control->cruza_medianoche = $cruzaMedianoche;
            // id_operadora no se modifica, mantiene la operadora original
            $control->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Turno actualizado exitosamente',
                'data' => $control->load(['turno.vehiculo', 'turno.conductor'])
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar turno: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el turno: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un control de turno
     */
    public function deleteControlTurno($id)
    {
        try {
            // Usar la primary key correcta
            $control = ControlTurno::where('id_control', $id)->firstOrFail();
            $control->delete();

            return response()->json([
                'success' => true,
                'message' => 'Turno eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar turno: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el turno'
            ], 500);
        }
    }

    public function turnosObligatorios()
    {
        $turnos = TurnoObligatorio::with([
            'vehiculo',
            'conductor',
            'asignadoPor'
        ])
        ->whereDate('fecha_turno', '>=', Carbon::today())
        ->orderBy('fecha_turno', 'asc')
        ->paginate(20);

        return view('operadora.turnos-obligatorios', compact('turnos'));
    }

    public function vehiculos()
    {
        $vehiculos = Vehiculo::with('propietario')
            ->where('estado', 'activo')
            ->orderBy('numero_interno', 'asc')
            ->paginate(20);

        return view('operadora.vehiculos', compact('vehiculos'));
    }
}