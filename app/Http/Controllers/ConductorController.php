<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudCambioRuta;
use App\Models\Conductor;
use App\Models\Vehiculo;
use App\Models\User;

class ConductorController extends Controller
{
    /**
     * Dashboard del conductor
     */
    public function dashboard()
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();
        
        // ✅ Intentar obtener el conductor relacionado
        $conductor = Conductor::where('id_usuario', $usuario->id_usuario)->first();
        
        // Si no existe en conductores, crear un objeto con datos del usuario
        if (!$conductor) {
            $conductor = (object)[
                'primer_nombre' => $usuario->nombre ?? 'Usuario',
                'segundo_nombre' => '',
                'primer_apellido' => $usuario->Apellido ?? '',
                'segundo_apellido' => '',
                'tipo_documento' => 'CC',
                'numero_documento' => 'N/A',
                'telefono' => 'N/A',
                'celular' => 'N/A',
                'email' => $usuario->correo ?? 'N/A',
                'licencia' => 'N/A',
                'categoria' => 'N/A',
                'estado' => $usuario->activo ? 'Activo' : 'Inactivo',
                'id_conductor' => $usuario->id_usuario, // Usar id_usuario como fallback
            ];
        }
        
        // Determinar qué ID usar para las consultas
        $idConductor = isset($conductor->id_conductor) 
            ? $conductor->id_conductor 
            : $usuario->id_usuario;
        
        // Obtener estadísticas
        $estadisticas = [
            'solicitudes_pendientes' => SolicitudCambioRuta::where('id_conductor', $idConductor)
                ->where('estado', 'pendiente')
                ->count(),
            'solicitudes_aprobadas' => SolicitudCambioRuta::where('id_conductor', $idConductor)
                ->where('estado', 'aprobado')
                ->count(),
            'solicitudes_rechazadas' => SolicitudCambioRuta::where('id_conductor', $idConductor)
                ->where('estado', 'rechazado')
                ->count(),
            'total_solicitudes' => SolicitudCambioRuta::where('id_conductor', $idConductor)
                ->count(),
        ];
        
        // Obtener últimas solicitudes
        $ultimasSolicitudes = SolicitudCambioRuta::where('id_conductor', $idConductor)
            ->orderBy('fecha_solicitud', 'desc')
            ->limit(5)
            ->get();
        
        return view('conductor.dashboard', compact('conductor', 'usuario', 'estadisticas', 'ultimasSolicitudes'));
    }

    /**
     * Mostrar el formulario de nueva solicitud
     */
    public function solicitudesCambioRuta()
    {
        $conductores = Conductor::all();
        $vehiculos = Vehiculo::all();
        
        return view('conductor.solicitudes-cambio-ruta', compact('conductores', 'vehiculos'));
    }
    
    /**
     * Guardar la nueva solicitud
     */
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
            'tarifa_cobrada' => 'required|numeric|min:0',
        ]);

        // Validación para evitar duplicados
        $solicitudExistente = SolicitudCambioRuta::where('id_conductor', $validated['id_conductor'])
            ->where('id_vehiculo', $validated['id_vehiculo'])
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitudExistente) {
            return back()->withErrors([
                'error' => 'Ya existe una solicitud activa para este conductor y vehículo.'
            ])->withInput();
        }

        try {
            SolicitudCambioRuta::create([
                'id_conductor' => $validated['id_conductor'],
                'id_vehiculo' => $validated['id_vehiculo'],
                'id_tarifa_destino' => null,
                'fecha_solicitud' => now(),
                'fecha_viaje_programada' => $validated['fecha_viaje_programada'],
                'nombre_contratante' => $validated['nombre_contratante'],
                'documento_contratante' => $validated['documento_contratante'],
                'telefono_contratante' => $validated['telefono_contratante'],
                'direccion_origen' => $validated['direccion_origen'],
                'direccion_destino' => $validated['direccion_destino'],
                'numero_pasajeros' => $validated['numero_pasajeros'] ?? 1,
                'tarifa_cobrada' => $validated['tarifa_cobrada'],
                'estado' => 'pendiente',
            ]);

            return redirect()->route('conductor.dashboard')
                ->with('success', '✅ Solicitud creada exitosamente');
                
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al crear la solicitud: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Mostrar los turnos del conductor
     */
    public function misTurnos()
    {
        $usuario = auth()->user();
        $conductor = Conductor::where('id_usuario', $usuario->id_usuario)->first();
        $idConductor = $conductor ? $conductor->id_conductor : $usuario->id_usuario;
        
        // Si tienes modelo Turno
        // $turnos = Turno::where('id_conductor', $idConductor)->get();
        $turnos = [];
        
        return view('conductor.mis-turnos', compact('turnos'));
    }

    /**
     * Mostrar alertas del conductor
     */
    public function alertas()
    {
        $alertas = [];
        return view('conductor.alertas', compact('alertas'));
    }

    /**
     * Listado de conductores
     */
    public function conductores()
    {
        $conductores = Conductor::all();
        return view('conductor.conductores', compact('conductores'));
    }

    /**
     * Mantenimiento general
     */
    public function mantenimientoGeneral()
    {
        return view('conductor.mantenimiento-general');
    }

    /**
     * Tarifas disponibles
     */
    public function tarifas()
    {
        $tarifas = [];
        return view('conductor.tarifas', compact('tarifas'));
    }

    /**
     * Listado de vehículos
     */
    public function vehiculos()
    {
        $vehiculos = Vehiculo::all();
        return view('conductor.vehiculos', compact('vehiculos'));
    }
}