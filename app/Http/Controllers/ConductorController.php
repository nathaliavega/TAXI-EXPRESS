<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudCambioRuta;
use App\Models\Conductor;
use App\Models\Vehiculo;

class ConductorController extends Controller
{
    // Dashboard del conductor
    public function dashboard()
    {
        return view('conductor.dashboard');
    }

    // ✅ Mostrar el formulario de nueva solicitud
    public function solicitudesCambioRuta()
    {
        $conductores = Conductor::all();
        $vehiculos = Vehiculo::all();
        
        return view('conductor.solicitudes-cambio-ruta', compact('conductores', 'vehiculos'));
    }
    
    // ✅ Guardar la nueva solicitud
    public function storeSolicitudCambioRuta(Request $request)
    {
        // Validar los datos
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

        // ✅ VALIDACIÓN PARA EVITAR DUPLICADOS
        $solicitudExistente = SolicitudCambioRuta::where('id_conductor', $validated['id_conductor'])
            ->where('id_vehiculo', $validated['id_vehiculo'])
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitudExistente) {
            return back()->withErrors([
                'error' => 'Ya existe una solicitud activa para este conductor y vehículo. Por favor, espera a que sea procesada.'
            ])->withInput();
        }

        // Crear la solicitud
        try {
            SolicitudCambioRuta::create([
                'id_conductor' => $validated['id_conductor'],
                'id_vehiculo' => $validated['id_vehiculo'],
                'id_tarifa_destino' => null, // Se asignará después si es necesario
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

    // ✅ Mis Turnos - CORREGIDO
    public function misTurnos()
    {
        $conductorId = auth()->user()->id_usuario;
        
        // Obtener los turnos (ajusta según tu modelo)
        $turnos = []; // Cambia esto por tu lógica real
        // Ejemplo: $turnos = Turno::where('id_conductor', $conductorId)->get();
        
        return view('conductor.mis-turnos', compact('turnos'));
    }

    // Otros métodos
    public function alertas()
    {
        $alertas = []; // Ajusta según tu lógica
        return view('conductor.alertas', compact('alertas'));
    }

    public function conductores()
    {
        $conductores = Conductor::all();
        return view('conductor.conductores', compact('conductores'));
    }

    public function mantenimientoGeneral()
    {
        return view('conductor.mantenimiento-general');
    }

    public function tarifas()
    {
        $tarifas = []; // Ajusta según tu lógica
        return view('conductor.tarifas', compact('tarifas'));
    }

    public function vehiculos()
    {
        $vehiculos = Vehiculo::all();
        return view('conductor.vehiculos', compact('vehiculos'));
    }
}