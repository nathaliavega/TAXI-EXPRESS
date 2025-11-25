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
use App\Models\Vehiculo; // ✅ AGREGAR ESTE IMPORT
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
        $mantenimientos = MantenimientoGeneral::where('activo', true)
            ->orderBy('nombre', 'asc')
            ->paginate(20);

        return view('conductor.mantenimiento-general', compact('mantenimientos'));
    }

    // ✅ MÉTODO EXISTENTE - MUESTRA LA LISTA DE SOLICITUDES
    // Puedes renombrarlo a listarSolicitudes() si quieres
    public function solicitudesCambioRuta()
    {
        $conductor = $this->getConductorAutenticado();

        if (!$conductor) {
            return redirect()->route('conductor.dashboard')
                ->with('error', 'No se encontró información del conductor');
        }

        $solicitudes = SolicitudCambioRuta::with([
            'conductor',
            'vehiculo',
            'tarifaDestino',
            'autorizadoPor'
        ])
        ->where('id_conductor', $conductor->id_conductor)
        ->orderBy('fecha_solicitud', 'desc')
        ->paginate(20);

        return view('conductor.solicitudes-cambio-ruta-lista', compact('solicitudes')); // ✅ Cambié el nombre de la vista
    }

    // ✅ NUEVO MÉTODO - MUESTRA EL FORMULARIO PARA NUEVA SOLICITUD
    public function nuevaSolicitudCambioRuta()
    {
        $conductores = Conductor::where('activo', true)->orderBy('nombre')->get();
        $vehiculos = Vehiculo::where('activo', true)->orderBy('placa')->get();
        
        return view('conductor.solicitudes-cambio-ruta', compact('conductores', 'vehiculos'));
    }

    // ✅ NUEVO MÉTODO - GUARDA LA SOLICITUD
    public function storeSolicitudCambioRuta(Request $request)
    {
        $validated = $request->validate([
            'id_conductor' => 'required|exists:conductores,id_conductor',
            'id_vehiculo' => 'required|exists:vehiculos,id_vehiculo',
            'origen_actual' => 'required|string|max:255',
            'destino_actual' => 'required|string|max:255',
            'codigo_ruta_actual' => 'required|string|max:50',
            'nuevo_origen' => 'required|string|max:255',
            'nuevo_destino' => 'required|string|max:255',
            'codigo_nueva_ruta' => 'required|string|max:50',
            'motivo' => 'required|string',
            'fecha_efectiva' => 'required|date',
            'documentos.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ]);

        try {
            // Guardar la solicitud
            $solicitud = SolicitudCambioRuta::create([
                'id_conductor' => $validated['id_conductor'],
                'id_vehiculo' => $validated['id_vehiculo'],
                'origen_actual' => $validated['origen_actual'],
                'destino_actual' => $validated['destino_actual'],
                'codigo_ruta_actual' => $validated['codigo_ruta_actual'],
                'nuevo_origen' => $validated['nuevo_origen'],
                'nuevo_destino' => $validated['nuevo_destino'],
                'codigo_nueva_ruta' => $validated['codigo_nueva_ruta'],
                'motivo' => $validated['motivo'],
                'fecha_efectiva' => $validated['fecha_efectiva'],
                'fecha_solicitud' => now(),
                'estado' => 'Pendiente',
            ]);

            // Manejar archivos adjuntos si existen
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $documento) {
                    $nombreArchivo = time() . '_' . uniqid() . '.' . $documento->getClientOriginalExtension();
                    $ruta = $documento->storeAs('solicitudes/documentos', $nombreArchivo, 'public');
                    
                    // Si tienes una tabla de documentos, guárdala aquí
                    // DocumentoSolicitud::create(['id_solicitud' => $solicitud->id, 'ruta' => $ruta]);
                }
            }

            return redirect()->route('conductor.solicitudes')->with('success', '✅ Solicitud enviada correctamente');
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al guardar la solicitud: ' . $e->getMessage());
        }
    }

    public function propietarios()
    {
        $propietarios = Propietario::where('activo', true)
            ->withCount('vehiculos')
            ->orderBy('razon_social', 'asc')
            ->paginate(20);

        return view('conductor.propietarios', compact('propietarios'));
    }

  
    public function tarifas()
    {
        $tarifas = TarifaDestino::where('activa', true)
            ->orderBy('nombre_destino', 'asc')
            ->paginate(20);

        return view('conductor.tarifas', compact('tarifas'));
    }
}