<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Conductor;
use App\Models\Propietario;
use App\Models\Alerta;
use App\Models\SolicitudCambioRuta;
use App\Models\TarifaDestino;
use App\Models\MantenimientoGeneral;
use App\Models\TurnoObligatorio;
use App\Models\ControlTurno;
use App\Models\ServicioMantenimiento;
use Carbon\Carbon;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        $vehiculosActivos = Vehiculo::where('estado', 'activo')->count();
        $conductoresActivos = Conductor::where('estado', 'activo')->count();
        $turnosHoy = TurnoObligatorio::whereDate('fecha_turno', Carbon::today())->count();
        $alertasPendientes = Alerta::where('resuelta', false)->count();

        $alertasRecientes = Alerta::with(['vehiculo', 'conductor'])
            ->where('resuelta', false)
            ->orderByRaw("CASE 
                WHEN prioridad = 'critica' THEN 1
                WHEN prioridad = 'alta' THEN 2
                WHEN prioridad = 'media' THEN 3
                ELSE 4
            END")
            ->orderBy('fecha_alerta', 'desc')
            ->limit(5)
            ->get();

        $solicitudesRecientes = SolicitudCambioRuta::with(['conductor', 'vehiculo', 'tarifaDestino'])
            ->whereNull('autorizado_por')
            ->orderBy('fecha_solicitud', 'desc')
            ->limit(5)
            ->get();

        $conductoresRecientes = Conductor::orderBy('fecha_vinculacion', 'desc')->limit(5)->get();
        $vehiculosRecientes = Vehiculo::with('propietario')->orderBy('fecha_vinculacion', 'desc')->limit(5)->get();
        $propietariosRecientes = Propietario::orderBy('fecha_registro', 'desc')->limit(5)->get();
        $tarifasDestino = TarifaDestino::where('activa', true)->orderBy('tarifa_base', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'vehiculosActivos',
            'conductoresActivos',
            'turnosHoy',
            'alertasPendientes',
            'alertasRecientes',
            'solicitudesRecientes',
            'conductoresRecientes',
            'vehiculosRecientes',
            'propietariosRecientes',
            'tarifasDestino'
        ));
    }

    public function vehiculos()
    {
        $vehiculos = Vehiculo::with('propietario')
            ->orderBy('numero_interno', 'asc')
            ->paginate(20);
        
        return view('admin.vehiculos', compact('vehiculos'));
    }

    public function conductores()
    {
        $conductores = Conductor::orderBy('primer_apellido', 'asc')
            ->orderBy('primer_nombre', 'asc')
            ->paginate(20);
        
        return view('admin.conductores', compact('conductores'));
    }

    
    public function propietarios()
    {
        $propietarios = Propietario::withCount('vehiculos')
            ->orderBy('razon_social', 'asc')
            ->paginate(20);
        
        return view('admin.propietarios', compact('propietarios'));
    }

    public function alertas()
    {
        $alertas = Alerta::with(['vehiculo', 'conductor'])
            ->orderBy('resuelta', 'asc')
            ->orderByRaw("CASE 
                WHEN prioridad = 'critica' THEN 1 
                WHEN prioridad = 'alta' THEN 2 
                WHEN prioridad = 'media' THEN 3 
                ELSE 4 END")
            ->orderBy('fecha_alerta', 'desc')
            ->paginate(20);
        
        return view('admin.alertas', compact('alertas'));
    }
    public function solicitudesCambioRuta()
{
    $solicitudes = SolicitudCambioRuta::with(['conductor', 'vehiculo', 'tarifaDestino', 'autorizadoPor'])
        ->orderByRaw('CASE WHEN autorizado_por IS NULL THEN 0 ELSE 1 END') // Pendientes primero
        ->orderBy('fecha_solicitud', 'desc')
        ->paginate(20);
    
    return view('admin.solicitudes-cambio-ruta', compact('solicitudes'));
}
   public function aprobarSolicitud($id)
{
    try {
        $solicitud = SolicitudCambioRuta::findOrFail($id);

        // Verificar si ya fue procesada
        if ($solicitud->autorizado_por) {
            return redirect()->back()->with('error', 'Esta solicitud ya fue procesada');
        }

        // Aprobar la solicitud
        $solicitud->autorizado_por = auth()->id();
        $solicitud->fecha_autorizacion = now();
        $solicitud->save();

        // NO actualizar la tarifa del conductor porque la columna no existe
        // Si necesitas actualizar algo más, hazlo aquí

        return redirect()->back()->with('success', 'Solicitud aprobada exitosamente');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al aprobar la solicitud: ' . $e->getMessage());
    }
}

public function rechazarSolicitud($id)
{
    try {
        $solicitud = SolicitudCambioRuta::findOrFail($id);

        // Verificar si ya fue procesada
        if ($solicitud->autorizado_por) {
            return redirect()->back()->with('error', 'Esta solicitud ya fue procesada');
        }

        // Rechazar la solicitud (puedes usar un campo estado o simplemente no aprobarla)
        // Como no tienes campo de estado, simplemente no actualizamos nada
        // o podrías eliminar la solicitud si lo prefieres
        
        return redirect()->back()->with('success', 'Solicitud rechazada');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al rechazar la solicitud: ' . $e->getMessage());
    }
}
    
    public function tarifasDestino()
    {
        $tarifas = TarifaDestino::orderBy('nombre_destino', 'asc')
            ->paginate(20);
        
        return view('admin.tarifas-destino', compact('tarifas'));
    }

    public function mantenimientoGeneral()
    {
       $mantenimientos = MantenimientoGeneral::orderBy('fecha_programada', 'desc')
        ->paginate(20);

    // Agregar esta línea para obtener los vehículos
    $vehiculos = Vehiculo::where('estado', 'activo')
        ->orderBy('numero_interno', 'asc')
        ->get();

    return view('admin.mantenimiento-general', compact('mantenimientos', 'vehiculos'));
    }
}