<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conductor;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\DB;

class ConductorController extends Controller
{
    /**
     * Mostrar el formulario de solicitudes de cambio de ruta
     * Ruta: GET /conductor/solicitudes-cambio-ruta
     */
    public function nuevaSolicitudCambioRuta()
    {
        // Obtener todos los conductores (solo columnas que existen)
        $conductores = Conductor::select(
            'id_conductor',
            'primer_nombre',
            'primer_apellido',
            'tipo_documento',
            'numero_documento'
        )->get();
        
        // Obtener todos los vehículos
        $vehiculos = Vehiculo::select(
            'id_vehiculo',
            'placa',
            'marca',
            'modelo'
        )->get();
        
        return view('conductor.solicitudes-cambio-ruta', compact('conductores', 'vehiculos'));
    }
    
    /**
     * Guardar la solicitud de cambio de ruta
     * Ruta: POST /conductor/solicitudes-cambio-ruta
     */
    public function storeSolicitudCambioRuta(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
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
        ], [
            'id_conductor.required' => 'Debe seleccionar un conductor',
            'id_vehiculo.required' => 'Debe seleccionar un vehículo',
            'nombre_contratante.required' => 'El nombre del contratante es obligatorio',
            'documento_contratante.required' => 'El documento del contratante es obligatorio',
            'telefono_contratante.required' => 'El teléfono del contratante es obligatorio',
            'direccion_origen.required' => 'La dirección de origen es obligatoria',
            'direccion_destino.required' => 'La dirección de destino es obligatoria',
            'tarifa_cobrada.required' => 'La tarifa es obligatoria',
            'tarifa_cobrada.numeric' => 'La tarifa debe ser un número válido',
            'numero_pasajeros.min' => 'Debe haber al menos 1 pasajero',
        ]);

        try {
            // Insertar la solicitud en la base de datos
            DB::table('solicitudes_cambio_ruta')->insert([
                'id_conductor' => $validatedData['id_conductor'],
                'id_vehiculo' => $validatedData['id_vehiculo'],
                'id_tarifa_destino' => 1, // TODO: Calcular según la tarifa real
                'nombre_contratante' => $validatedData['nombre_contratante'],
                'documento_contratante' => $validatedData['documento_contratante'],
                'telefono_contratante' => $validatedData['telefono_contratante'],
                'direccion_origen' => $validatedData['direccion_origen'],
                'direccion_destino' => $validatedData['direccion_destino'],
                'fecha_viaje_programada' => $validatedData['fecha_viaje_programada'] ?? now(),
                'numero_pasajeros' => $validatedData['numero_pasajeros'] ?? 1,
                'tarifa_cobrada' => $validatedData['tarifa_cobrada'],
                'fecha_solicitud' => now(),
            ]);
            
            return redirect()->route('conductor.solicitudes-cambio-ruta')
                ->with('success', '✅ Solicitud de servicio registrada exitosamente');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al registrar la solicitud: ' . $e->getMessage()])
                ->withInput();
        }
    }
}