<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conductor;  // Asegúrate de tener este modelo
use App\Models\Vehiculo;   // Asegúrate de tener este modelo

class ConductorController extends Controller
{
    public function mostrarFormulario()
    {
        // Obtener todos los conductores de la base de datos
        $conductores = Conductor::all();
        
        // Obtener todos los vehículos de la base de datos
        $vehiculos = Vehiculo::all();
        
        // Pasar los datos a la vista
        return view('conductor.solicitudes-cambio-ruta', compact('conductores', 'vehiculos'));
    }
    
    public function guardarSolicitud(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'id_conductor' => 'required|exists:conductores,id_conductor',
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'nombre_contratante' => 'required|string',
            'documento_contratante' => 'required|string',
            'telefono_contratante' => 'required|string',
            'origen_actual' => 'required|string',
            'direccion_origen' => 'required|string',
            'direccion_destino' => 'required|string',
            'fecha_viaje_programada' => 'nullable|date',
            'numero_pasajeros' => 'nullable|integer|min:1',
            'tarifa_cobrada' => 'nullable|numeric|min:0',
        ]);
        
        // Aquí guardarías los datos en tu base de datos
        // SolicitudServicio::create($validatedData);
        
        return redirect()->back()->with('success', 'Solicitud enviada exitosamente');
    }
}

