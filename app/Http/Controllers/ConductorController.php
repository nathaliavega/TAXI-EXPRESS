<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudCambioRuta;
use App\Models\Conductor;
use App\Models\Vehiculo;
use App\Models\Usuario;

class ConductorController extends Controller
{
    // ✅ Dashboard del conductor - ACTUALIZADO
    public function dashboard()
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();
        
        // Buscar el conductor asociado al usuario
        // Ajusta esto según cómo esté relacionado tu usuario con conductor
        // Opción 1: Si el id_usuario es igual al id_conductor
        $conductor = Conductor::where('id_conductor', $usuario->id_usuario)->first();
        
        // Opción 2: Si existe una relación diferente, ajusta según tu base de datos
        // $conductor = Conductor::where('usuario_id', $usuario->id_usuario)->first();
        
        // Si no encuentra conductor, crear datos básicos desde el usuario
        if (!$conductor) {
            $conductor = (object)[
                'primer_nombre' => $usuario->nombre ?? 'Usuario',
                'segundo_nombre' => '',
                'primer_apellido' => '',
                'segundo_apellido' => '',
                'tipo_documento' => 'CC',
                'numero_documento' => $usuario->documento ?? 'N/A',
                'telefono' => $usuario->telefono ?? 'N/A',
                'email' => $usuario->email ?? 'N/A',
            ];
        }
        
        // Obtener estadísticas del conductor
        $estadisticas = [
            'solicitudes_pendientes' => SolicitudCambioRuta::where('id_conductor', $usuario->id_usuario)
                ->where('estado', 'pendiente')
                ->count(),
            'solicitudes_aprobadas' => SolicitudCambioRuta::where('id_conductor', $usuario->id_usuario)
                ->where('estado', 'aprobado')
                ->count(),
            'solicitudes_rechazadas' => SolicitudCambioRuta::where('id_conductor', $usuario->id_usuario)
                ->where('estado', 'rechazado')
                ->count(),
            'total_solicitudes' => SolicitudCambioRuta::where('id_conductor', $usuario->id_usuario)
                ->count(),
        ];
        
        // Obtener últimas solicitudes
        $ultimasSolicitudes = SolicitudCambioRuta::where('id_conductor', $usuario->id_usuario)
            ->orderBy('fecha_solicitud', 'desc')
            ->limit(5)
            ->get();
        
        return view('conductor.dashboard', compact('conductor', 'usuario', 'estadisticas', 'ultimasSolicitudes'));
    }

    // ... resto de métodos
}