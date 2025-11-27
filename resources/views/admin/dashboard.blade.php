<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        
        .navbar {
            background: linear-gradient(135deg, #fa4807ff, #f7931e);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 { font-size: 22px; }
        .btn-logout {
            background: white;
            color: #ff6b35;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-logout:hover { background: #f0f0f0; }
        
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        
        .menu-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .menu-nav a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .menu-nav a:hover {
            background: linear-gradient(135deg, #ff5722, #f57c00);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,107,53,0.4);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #ff6b35;
            transition: transform 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .stat-card h3 { color: #666; font-size: 14px; margin-bottom: 10px; }
        .stat-card .number { font-size: 36px; font-weight: bold; color: #ff6b35; }
        .stat-card.alertas { border-left-color: #e53e3e; }
        .stat-card.alertas .number { color: #e53e3e; }
        .stat-card.success { border-left-color: #38a169; }
        .stat-card.success .number { color: #38a169; }
        .stat-card.warning { border-left-color: #dd6b20; }
        .stat-card.warning .number { color: #dd6b20; }
        .stat-card.purple { border-left-color: #805ad5; }
        .stat-card.purple .number { color: #805ad5; }
        
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 20px;
        }
        
        .section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .section h2 {
            color: #ff6b35;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
        }
        .section h2 a {
            font-size: 13px;
            color: #ff6b35;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .section h2 a:hover { 
            text-decoration: underline;
            color: #ff5722;
        }
        
        .list-item {
            padding: 15px;
            margin-bottom: 10px;
            background: #f9f9f9;
            border-radius: 0 8px 8px 0;
            border-left: 4px solid #ff6b35;
            transition: all 0.2s ease;
        }
        .list-item:hover { 
            background: #fff5f0;
            transform: translateX(5px);
        }
        .list-item strong { color: #333; }
        .list-item .meta { font-size: 13px; color: #666; margin-top: 5px; }
        
        .alert-item {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 0 8px 8px 0;
            transition: all 0.2s ease;
        }
        .alert-item:hover {
            transform: translateX(5px);
        }
        .alert-item.critica { border-left: 4px solid #e53e3e; background: #fff5f5; }
        .alert-item.alta { border-left: 4px solid #dd6b20; background: #fffaf0; }
        .alert-item.media { border-left: 4px solid #d69e2e; background: #fffff0; }
        .alert-item.baja { border-left: 4px solid #38a169; background: #f0fff4; }
        .alert-item strong { color: #333; display: block; margin-bottom: 5px; }
        .alert-item p { font-size: 14px; color: #555; margin: 5px 0; }
        .alert-item small { font-size: 12px; color: #888; }
        
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge.critica { background: #e53e3e; color: white; }
        .badge.alta { background: #dd6b20; color: white; }
        .badge.media { background: #d69e2e; color: #333; }
        .badge.baja { background: #38a169; color: white; }
        .badge.success { background: #38a169; color: white; }
        .badge.warning { background: #d69e2e; color: #333; }
        .badge.danger { background: #e53e3e; color: white; }
        .badge.info { background: #805ad5; color: white; }
        .badge.secondary { background: #718096; color: white; }
        
        table { width: 100%; border-collapse: collapse; }
        table th {
            text-align: left;
            padding: 12px;
            background: #ff6b35;
            color: white;
            font-size: 13px;
        }
        table th:first-child { border-radius: 8px 0 0 0; }
        table th:last-child { border-radius: 0 8px 0 0; }
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        table tr:hover { background: #fff5f0; }
        
        .empty-state {
            text-align: center;
            padding: 30px;
            color: #888;
        }
        .empty-state .icon { font-size: 40px; margin-bottom: 10px; }
        
        .alert-box {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-box.success { background: #c6f6d5; color: #22543d; border-left: 4px solid #38a169; }
        .alert-box.error { background: #fed7d7; color: #742a2a; border-left: 4px solid #e53e3e; }
        
        @media (max-width: 768px) {
            .content-grid { grid-template-columns: 1fr; }
            .navbar { flex-direction: column; gap: 10px; }
            .navbar h1 { font-size: 18px; text-align: center; }
            .menu-nav { justify-content: center; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🚖 Panel de Administrador - Taxi Express Pamplona</h1>
        <div class="user-info">
            <span>Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 15px;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="alert-box success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-box error">⚠️ {{ session('error') }}</div>
        @endif

        <div class="menu-nav">
            <a href="{{ route('admin.vehiculos') }}">🚐 Vehículos</a>
            <a href="{{ route('admin.conductores') }}">👥 Conductores</a>
            <a href="{{ route('admin.propietarios') }}">🏢 Propietarios</a>
            <a href="{{ route('admin.alertas') }}">⚠️ Alertas</a>
            <a href="{{ route('admin.solicitudes-cambio-ruta') }}">📝 Control de Solicitudes</a>
            <a href="{{ route('admin.tarifas-destino') }}">💰 Tarifas</a>
            <a href="{{ route('admin.mantenimiento-general') }}">📋 Tipos de Mantenimiento</a>
            <a href="{{ route('admin.admin.servicio-mantenimiento') }}">🔧 Servicios Realizados</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card success">
                <h3>🚐 Vehículos Activos</h3>
                <div class="number">{{ $vehiculosActivos ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>👥 Conductores Activos</h3>
                <div class="number">{{ $conductoresActivos ?? 0 }}</div>
            </div>
            <div class="stat-card warning">
                <h3>📅 Turnos Hoy</h3>
                <div class="number">{{ $turnosHoy ?? 0 }}</div>
            </div>
            <div class="stat-card purple">
                <h3>🔧 Servicios Mantenimiento</h3>
                <div class="number">{{ $serviciosMantenimiento ?? 0 }}</div>
            </div>
            <div class="stat-card alertas">
                <h3>⚠️ Alertas Pendientes</h3>
                <div class="number">{{ $alertasPendientes ?? 0 }}</div>
            </div>
        </div>

        <div class="content-grid">
            <div class="section">
                <h2>⚠️ Alertas Recientes <a href="{{ route('admin.alertas') }}">Ver todas →</a></h2>
                @forelse($alertasRecientes ?? [] as $alerta)
                    <div class="alert-item {{ strtolower($alerta->prioridad) }}">
                        <strong>{{ $alerta->titulo }}</strong>
                        <span class="badge {{ strtolower($alerta->prioridad) }}">{{ ucfirst($alerta->prioridad) }}</span>
                        <p>{{ Str::limit($alerta->descripcion, 80) }}</p>
                        <small>
                            @if($alerta->vehiculo)🚐 {{ $alerta->vehiculo->placa }}@endif
                            @if($alerta->conductor) | 👤 {{ $alerta->conductor->primer_nombre }}@endif
                            @if($alerta->fecha_vencimiento) | 📅 {{ \Carbon\Carbon::parse($alerta->fecha_vencimiento)->format('d/m/Y') }}@endif
                        </small>
                    </div>
                @empty
                    <div class="empty-state"><div class="icon">✅</div><p>No hay alertas pendientes</p></div>
                @endforelse
            </div>

            <div class="section">
                <h2>🔧 Mantenimientos Recientes <a href="{{ route('admin.admin.servicio-mantenimiento') }}">Ver todos →</a></h2>
                @forelse($mantenimientosRecientes ?? [] as $mantenimiento)
                    <div class="list-item">
                        <strong>{{ $mantenimiento->mantenimientoGeneral->nombre ?? 'N/A' }}</strong>
                        <span class="badge info">${{ number_format($mantenimiento->costo ?? 0, 0, ',', '.') }}</span>
                        <div class="meta">
                            🚐 {{ $mantenimiento->vehiculo->placa ?? 'N/A' }} 
                            | 📅 {{ \Carbon\Carbon::parse($mantenimiento->fecha_mantenimiento)->format('d/m/Y') }}
                        </div>
                        @if($mantenimiento->taller)
                            <div class="meta">🏭 {{ $mantenimiento->taller }}</div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state"><div class="icon">🔧</div><p>No hay mantenimientos registrados</p></div>
                @endforelse
            </div>

            <div class="section">
                <h2>📝 Solicitudes Pendientes <a href="{{ route('admin.solicitudes-cambio-ruta') }}">Ver todas →</a></h2>
                @forelse($solicitudesRecientes ?? [] as $solicitud)
                    <div class="list-item">
                        <strong>{{ $solicitud->conductor->primer_nombre ?? 'N/A' }} {{ $solicitud->conductor->primer_apellido ?? '' }}</strong>
                        <span class="badge {{ $solicitud->autorizado_por ? 'success' : 'warning' }}">{{ $solicitud->autorizado_por ? 'Autorizado' : 'Pendiente' }}</span>
                        <div class="meta">🚐 {{ $solicitud->vehiculo->placa ?? 'N/A' }} | 📍 {{ $solicitud->tarifaDestino->nombre_destino ?? $solicitud->direccion_destino ?? 'N/A' }}</div>
                        <div class="meta">📅 {{ \Carbon\Carbon::parse($solicitud->fecha_viaje_programada)->format('d/m/Y H:i') }}</div>
                    </div>
                @empty
                    <div class="empty-state"><div class="icon">📝</div><p>No hay solicitudes pendientes</p></div>
                @endforelse
            </div>

            <div class="section">
                <h2>👥 Conductores Recientes <a href="{{ route('admin.conductores') }}">Ver todos →</a></h2>
                <table>
                    <thead><tr><th>Nombre</th><th>Documento</th><th>Licencia</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($conductoresRecientes ?? [] as $conductor)
                            <tr>
                                <td><strong>{{ $conductor->primer_nombre }} {{ $conductor->primer_apellido }}</strong></td>
                                <td>{{ $conductor->tipo_documento }}: {{ $conductor->numero_documento }}</td>
                                <td>{{ $conductor->categoria_licencia }}</td>
                                <td><span class="badge {{ $conductor->estado == 'activo' ? 'success' : 'secondary' }}">{{ ucfirst($conductor->estado) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">No hay conductores</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="section">
                <h2>🚐 Vehículos Recientes <a href="{{ route('admin.vehiculos') }}">Ver todos →</a></h2>
                <table>
                    <thead><tr><th>Placa</th><th>Móvil</th><th>Marca/Modelo</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($vehiculosRecientes ?? [] as $vehiculo)
                            <tr>
                                <td><strong>{{ $vehiculo->placa }}</strong></td>
                                <td><span class="badge secondary">{{ $vehiculo->numero_interno }}</span></td>
                                <td>{{ $vehiculo->marca }} {{ $vehiculo->modelo }}</td>
                                <td><span class="badge {{ $vehiculo->estado == 'activo' ? 'success' : ($vehiculo->estado == 'en mantenimiento' ? 'warning' : 'secondary') }}">{{ ucfirst($vehiculo->estado) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">No hay vehículos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="section">
                <h2>💰 Tarifas Destinos <a href="{{ route('admin.tarifas-destino') }}">Ver todas →</a></h2>
                <table>
                    <thead><tr><th>Destino</th><th>Ciudad</th><th>Tarifa</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($tarifasDestino ?? [] as $tarifa)
                            <tr>
                                <td><strong>{{ $tarifa->nombre_destino }}</strong></td>
                                <td>{{ $tarifa->ciudad }}</td>
                                <td><strong style="color: #38a169;">${{ number_format($tarifa->tarifa_base, 0, ',', '.') }}</strong></td>
                                <td><span class="badge {{ $tarifa->activa ? 'success' : 'secondary' }}">{{ $tarifa->activa ? 'Activa' : 'Inactiva' }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">No hay tarifas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="section">
                <h2>🏢 Propietarios <a href="{{ route('admin.propietarios') }}">Ver todos →</a></h2>
                <table>
                    <thead><tr><th>Razón Social</th><th>NIT</th><th>Representante</th><th>Estado</th></tr></thead>
                    <tbody>
                        @forelse($propietariosRecientes ?? [] as $propietario)
                            <tr>
                                <td><strong>{{ $propietario->razon_social }}</strong></td>
                                <td>{{ $propietario->nit }}</td>
                                <td>{{ $propietario->representante_legal }}</td>
                                <td><span class="badge {{ $propietario->activo ? 'success' : 'secondary' }}">{{ $propietario->activo ? 'Activo' : 'Inactivo' }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">No hay propietarios</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>