<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use App\Models\SolicitudCambioRuta;
use App\Models\TarifaDestino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConductorController extends Controller
{
    // Mostrar formulario y listado
    public function solicitudesCambioRuta()
    {
        $conductor = Conductor::where('email', auth()->user()->email)->first();
        
        if (!$conductor) {
            return redirect()->route('conductor.dashboard')
                ->with('error', 'No se encontró información del conductor');
        }

        // Obtener la ruta actual del conductor
        $rutaActual = $conductor->vehiculo->tarifaDestino ?? null;

        // Obtener todas las tarifas disponibles
        $tarifas = TarifaDestino::where('estado', 'activo')->get();

        // Obtener solicitudes previas del conductor
        $solicitudes = SolicitudCambioRuta::where('id_conductor', $conductor->id_conductor)
            ->with(['tarifaActual', 'tarifaSolicitada'])
            ->orderBy('fecha_solicitud', 'desc')
            ->paginate(10);

        return view('conductor.solicitudes-cambio-ruta', compact('conductor', 'tarifas', 'solicitudes', 'rutaActual'));
    }

    // Guardar nueva solicitud
    public function storeSolicitudCambioRuta(Request $request)
    {
        $conductor = Conductor::where('email', auth()->user()->email)->first();
        
        if (!$conductor) {
            return back()->with('error', 'No se encontró información del conductor');
        }

        $validated = $request->validate([
            'id_tarifa_solicitada' => 'required|exists:tarifas_destinos,id_tarifa',
            'motivo' => 'required|string|min:20|max:500'
        ], [
            'id_tarifa_solicitada.required' => 'Debes seleccionar una ruta',
            'motivo.required' => 'El motivo es obligatorio',
            'motivo.min' => 'El motivo debe tener al menos 20 caracteres',
            'motivo.max' => 'El motivo no puede exceder 500 caracteres'
        ]);

        // Obtener la ruta actual
        $rutaActual = $conductor->vehiculo->tarifaDestino ?? null;
        
        if (!$rutaActual) {
            return back()->with('error', 'No tienes una ruta asignada actualmente');
        }

        // Verificar que no sea la misma ruta
        if ($rutaActual->id_tarifa == $validated['id_tarifa_solicitada']) {
            return back()->with('error', 'No puedes solicitar la misma ruta que ya tienes asignada');
        }

        // Verificar que no tenga solicitudes pendientes
        $solicitudPendiente = SolicitudCambioRuta::where('id_conductor', $conductor->id_conductor)
            ->where('estado', 'pendiente')
            ->exists();

        if ($solicitudPendiente) {
            return back()->with('error', 'Ya tienes una solicitud pendiente. Espera la respuesta antes de crear otra.');
        }

        // Crear la solicitud
        SolicitudCambioRuta::create([
            'id_conductor' => $conductor->id_conductor,
            'id_tarifa_actual' => $rutaActual->id_tarifa,
            'id_tarifa_solicitada' => $validated['id_tarifa_solicitada'],
            'motivo' => $validated['motivo'],
            'estado' => 'pendiente',
            'fecha_solicitud' => now()
        ]);

        return back()->with('success', '✅ Solicitud enviada correctamente. El administrador la revisará pronto.');
    }
}