<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TurnoObligatorio;
use App\Models\Alerta;
use App\Models\Conductor;
use App\Models\MantenimientoGeneral;
use App\Models\SolicitudCambioRuta;
use App\Models\Propietario;
use App\Models\TarifaDestino;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ConductorController extends Controller
{
    
    private function getConductorAutenticado()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }
        
        return Conductor::where('email', $user->correo)->first();
    }

   
    public function dashboard()
    {
        $conductor = $this->getConductorAutenticado();

        if (!$conductor) {
            return view('conductor.dashboard', [
                'conductor' => null,
                'turnosProximos' => collect([]),
                'solicitudesPendientes' => 0,
                'alertas' => collect([]),
                'error' => 'No se encontró un perfil de conductor asociado a tu cuenta.'
            ]);
        }

        $turnosProximos = TurnoObligatorio::with('vehiculo')
            ->where('id_conductor', $conductor->id_conductor)
            ->whereDate('fecha_turno', '>=', Carbon::today())
            ->orderBy('fecha_turno', 'asc')
            ->limit(5)
            ->get();

       
        $solicitudesPendientes = SolicitudCambioRuta::where('id_conductor', $conductor->id_conductor)
            ->whereNull('autorizado_por')
            ->count();

        
        $alertas = Alerta::where('id_conductor', $conductor->id_conductor)
            ->where('resuelta', false)
            ->orderByRaw("CASE 
                WHEN prioridad = 'critica' THEN 1 
                WHEN prioridad = 'alta' THEN 2 
                WHEN prioridad = 'media' THEN 3 
                ELSE 4 END")
            ->orderBy('fecha_alerta', 'desc')
            ->limit(5)
            ->get();

        return view('conductor.dashboard', compact(
            'conductor',
            'turnosProximos',
            'solicitudesPendientes',
            'alertas'
        ));
    }

   
    public function misTurnos()
    {
        $conductor = $this->getConductorAutenticado();

        if (!$conductor) {
            return redirect()->route('conductor.dashboard')
                ->with('error', 'No se encontró información del conductor');
        }

        $turnos = TurnoObligatorio::with(['vehiculo', 'conductor', 'asignadoPor'])
            ->where('id_conductor', $conductor->id_conductor)
            ->whereDate('fecha_turno', '>=', Carbon::today())
            ->orderBy('fecha_turno', 'asc')
            ->paginate(20);

        return view('conductor.mis-turnos', compact('turnos'));
    }

    
    public function alertas()
    {
        $conductor = $this->getConductorAutenticado();

        if (!$conductor) {
            return redirect()->route('conductor.dashboard')
                ->with('error', 'No se encontró información del conductor');
        }

        $alertas = Alerta::with(['vehiculo', 'conductor'])
            ->where('id_conductor', $conductor->id_conductor)
            ->orderBy('resuelta', 'asc')
            ->orderByRaw("CASE 
                WHEN prioridad = 'critica' THEN 1 
                WHEN prioridad = 'alta' THEN 2 
                WHEN prioridad = 'media' THEN 3 
                ELSE 4 END")
            ->orderBy('fecha_alerta', 'desc')
            ->paginate(20);

        return view('conductor.alertas', compact('alertas'));
    }

    public function mantenimientoGeneral()
    {
        $mantenimientos = MantenimientoGeneral::orderBy('nombre', 'asc')
            ->paginate(20);

        return view('conductor.mantenimiento-general', compact('mantenimientos'));
    }

    // ✅ MÉTODO PARA MOSTRAR EL FORMULARIO DE NUEVA SOLICITUD
    public function nuevaSolicitudCambioRuta()
    {
        $conductores = Conductor::where('estado', 'activo')
            ->orderBy('primer_nombre')
            ->orderBy('primer_apellido')
            ->get();
        
        $vehiculos = Vehiculo::orderBy('placa')->get();
        
        return view('conductor.solicitudes-cambio-ruta', compact('conductores', 'vehiculos'));
    }

    // ✅ AQUÍ VA EL MÉTODO storeSolicitudCambioRuta - DESPUÉS DE nuevaSolicitudCambioRuta
    public function storeSolicitudCambioRuta(Request $request)
    {
        $validated = $request->validate([
            'id_conductor' => 'required|exists:conductores,id_conductor',
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'nombre_contratante' => 'required|string|max:200',
            'documento_contratante' => 'required|string|max:50',
            'telefono_contratante' => 'required|string|max:20',
            'direccion_origen' => 'required|string',
            'direccion_destino' => 'required|string',
            'fecha_viaje_programada' => 'nullable|date',
            'numero_pasajeros' => 'nullable|integer|min:1',
            'tarifa_cobrada' => 'nullable|numeric|min:0',
        ]);

        try {
            // Buscar una tarifa por defecto (la primera activa)
            $tarifaDefault = TarifaDestino::first();
            
            if (!$tarifaDefault) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'No hay tarifas configuradas en el sistema');
            }

            // Guardar la solicitud
            $solicitud = SolicitudCambioRuta::create([
                'id_conductor' => $validated['id_conductor'],
                'id_vehiculo' => $validated['id_vehiculo'],
                'id_tarifa_destino' => $tarifaDefault->id_tarifa,
                'nombre_contratante' => $validated['nombre_contratante'],
                'documento_contratante' => $validated['documento_contratante'],
                'telefono_contratante' => $validated['telefono_contratante'],
                'direccion_origen' => $validated['direccion_origen'],
                'direccion_destino' => $validated['direccion_destino'],
                'fecha_viaje_programada' => $validated['fecha_viaje_programada'] ?? now()->addHour(),
                'numero_pasajeros' => $validated['numero_pasajeros'] ?? 1,
                'tarifa_cobrada' => $validated['tarifa_cobrada'] ?? $tarifaDefault->tarifa,
                'fecha_solicitud' => now(),
            ]);

            return redirect()->route('conductor.dashboard')
                ->with('success', '✅ Solicitud enviada correctamente');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar la solicitud: ' . $e->getMessage());
        }
    }


  
    public function tarifas()
    {
        $tarifas = TarifaDestino::orderBy('nombre_destino', 'asc')
            ->paginate(20);

        return view('conductor.tarifas', compact('tarifas'));
    }
}
