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
use Illuminate\Support\Facades\Auth;

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
        ->orderBy('id_control', 'desc')
        ->paginate(20);

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

            $control = ControlTurno::where('id_control', $id)->firstOrFail();
            
            $turno = $control->turno;
            if ($turno->id_vehiculo != $validated['vehiculo_id'] || 
                $turno->id_conductor != $validated['conductor_id']) {
                
                $nuevoTurno = TurnoObligatorio::where('id_vehiculo', $validated['vehiculo_id'])
                    ->where('id_conductor', $validated['conductor_id'])
                    ->where('fecha_turno', Carbon::today())
                    ->first();
                
                if ($nuevoTurno) {
                    $control->id_turno = $nuevoTurno->id_turno;
                } else {
                    $turno->id_vehiculo = $validated['vehiculo_id'];
                    $turno->id_conductor = $validated['conductor_id'];
                    $turno->save();
                }
            }

            $horaInicio = strtotime($validated['hora_inicio']);
            $horaFin = strtotime($validated['hora_fin']);
            $cruzaMedianoche = $horaFin < $horaInicio;

            $control->nombre_franja = $validated['nombre_franja'];
            $control->hora_inicio = $validated['hora_inicio'];
            $control->hora_fin = $validated['hora_fin'];
            $control->hora_llamado = $validated['hora_llamado'];
            $control->respondio = $validated['respondio'];
            $control->en_servicio = $validated['en_servicio'];
            $control->cruza_medianoche = $cruzaMedianoche;
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

    /**
     * Mostrar listado de turnos obligatorios
     */
    public function turnosObligatorios()
    {
        $turnos = TurnoObligatorio::with([
            'vehiculo',
            'conductor',
            'asignadoPor'
        ])
        ->orderBy('fecha_turno', 'desc')
        ->paginate(20);

        // Obtener vehículos y conductores activos para los modales
        $vehiculos = Vehiculo::where('estado', 'activo')
            ->orderBy('numero_interno', 'asc')
            ->get();

        $conductores = Conductor::where('estado', 'activo')
            ->orderBy('primer_nombre', 'asc')
            ->get();

        return view('operadora.turnos-obligatorios', compact('turnos', 'vehiculos', 'conductores'));
    }

    /**
     * Crear un nuevo turno obligatorio
     */
    public function storeTurnoObligatorio(Request $request)
    {
        try {
            $request->validate([
                'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
                'id_conductor' => 'required|exists:conductores,id_conductor',
                'fecha_turno' => 'required|date|after_or_equal:today',
                'estado' => 'required|in:programado,cumplido,incumplido,justificado,cancelado'
            ], [
                'id_vehiculo.required' => 'Debe seleccionar un vehículo',
                'id_vehiculo.exists' => 'El vehículo seleccionado no existe',
                'id_conductor.required' => 'Debe seleccionar un conductor',
                'id_conductor.exists' => 'El conductor seleccionado no existe',
                'fecha_turno.required' => 'La fecha del turno es obligatoria',
                'fecha_turno.date' => 'La fecha debe ser válida',
                'fecha_turno.after_or_equal' => 'La fecha debe ser hoy o posterior',
                'estado.required' => 'El estado es obligatorio',
                'estado.in' => 'El estado seleccionado no es válido'
            ]);

            // Verificar si ya existe un turno para ese vehículo en esa fecha
            $existe = TurnoObligatorio::where('id_vehiculo', $request->id_vehiculo)
                ->whereDate('fecha_turno', $request->fecha_turno)
                ->exists();

            if ($existe) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => 'Ya existe un turno programado para este vehículo en esta fecha']);
            }

            DB::beginTransaction();

            // Debug: Verificar datos antes de crear
            $datosCreacion = [
                'id_vehiculo' => (int)$request->id_vehiculo,
                'id_conductor' => (int)$request->id_conductor,
                'fecha_turno' => $request->fecha_turno,
                'estado' => $request->estado,
                'asignado_por' => Auth::id(),
                'fecha_asignacion' => now()
            ];

            Log::info('Intentando crear turno con datos:', $datosCreacion);

            $turno = TurnoObligatorio::create($datosCreacion);

            Log::info('Turno creado exitosamente con ID: ' . $turno->id_turno);

            DB::commit();

            return redirect()
                ->route('operadora.turnos-obligatorios')
                ->with('success', 'Turno obligatorio creado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear turno obligatorio: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear el turno: ' . $e->getMessage()]);
        }
    }

    /**
     * Actualizar un turno obligatorio
     */
    public function updateTurnoObligatorio(Request $request, $id)
    {
        $turno = TurnoObligatorio::findOrFail($id);

        $request->validate([
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'id_conductor' => 'required|exists:conductores,id_conductor',
            'fecha_turno' => 'required|date',
            'estado' => 'required|in:programado,cumplido,incumplido,justificado,cancelado'
        ], [
            'id_vehiculo.required' => 'Debe seleccionar un vehículo',
            'id_vehiculo.exists' => 'El vehículo seleccionado no existe',
            'id_conductor.required' => 'Debe seleccionar un conductor',
            'id_conductor.exists' => 'El conductor seleccionado no existe',
            'fecha_turno.required' => 'La fecha del turno es obligatoria',
            'fecha_turno.date' => 'La fecha debe ser válida',
            'estado.required' => 'El estado es obligatorio',
            'estado.in' => 'El estado seleccionado no es válido'
        ]);

        // Verificar si ya existe otro turno para ese vehículo en esa fecha (excepto el actual)
        $existe = TurnoObligatorio::where('id_vehiculo', $request->id_vehiculo)
            ->where('fecha_turno', $request->fecha_turno)
            ->where('id_turno', '!=', $id)
            ->exists();

        if ($existe) {
            return back()
                ->withInput()
                ->with('error', 'Ya existe otro turno programado para este vehículo en esta fecha');
        }

        try {
            $turno->update([
                'id_vehiculo' => $request->id_vehiculo,
                'id_conductor' => $request->id_conductor,
                'fecha_turno' => $request->fecha_turno,
                'estado' => $request->estado
            ]);

            return redirect()
                ->route('operadora.turnos-obligatorios')
                ->with('success', 'Turno obligatorio actualizado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar turno obligatorio: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el turno obligatorio');
        }
    }

    /**
     * Eliminar un turno obligatorio
     */
    public function destroyTurnoObligatorio($id)
    {
        try {
            $turno = TurnoObligatorio::findOrFail($id);
            
            // Verificar si el turno ya fue cumplido
            if ($turno->estado == 'cumplido') {
                return back()->with('error', 'No se puede eliminar un turno que ya fue cumplido');
            }

            $turno->delete();

            return redirect()
                ->route('operadora.turnos-obligatorios')
                ->with('success', 'Turno obligatorio eliminado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar turno obligatorio: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el turno obligatorio');
        }
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