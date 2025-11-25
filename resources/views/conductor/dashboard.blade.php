<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Conductor</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .navbar {
            background: linear-gradient(135deg, #00695c, #00bfa5);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-logout {
            background: white;
            color: #00695c;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-logout:hover { background: #e0f2f1; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        
        /* Menú de navegación */
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
            background: linear-gradient(135deg, #00695c, #00897b);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .menu-nav a:hover {
            background: linear-gradient(135deg, #004d40, #00695c);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,105,92,0.4);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #00695c;
        }
        .stat-card h3 { color: #666; font-size: 14px; margin-bottom: 10px; }
        .stat-card .number { font-size: 36px; font-weight: bold; color: #00695c; }
        .stat-card.alertas { border-left-color: #ff6600; }
        .stat-card.alertas .number { color: #ff6600; }
        
        .section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .section h2 {
            color: #00695c;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0f2f1;
        }
        
        .turno-item {
            padding: 15px;
            border-left: 4px solid #00695c;
            margin-bottom: 10px;
            background: #f9f9f9;
            border-radius: 0 8px 8px 0;
        }
        .turno-item:hover { background: #e0f2f1; }
        
        .info-conductor {
            background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 5px solid #00695c;
        }
        .info-conductor strong { color: #00695c; }
        
        .alert-box {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        
        .alerta-item {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 0 8px 8px 0;
        }
        .alerta-item.critica { border-left: 4px solid #d32f2f; background: #ffebee; }
        .alerta-item.alta { border-left: 4px solid #f57c00; background: #fff3e0; }
        .alerta-item.media { border-left: 4px solid #fbc02d; background: #fffde7; }
        .alerta-item.baja { border-left: 4px solid #388e3c; background: #e8f5e9; }
        
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge.critica { background: #d32f2f; color: white; }
        .badge.alta { background: #f57c00; color: white; }
        .badge.media { background: #fbc02d; color: #333; }
        .badge.baja { background: #388e3c; color: white; }
        
        .empty-state { text-align: center; padding: 30px; color: #666; }
        .empty-state .icon { font-size: 48px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🚖 Panel de Conductor - Taxi Express Pamplona</h1>
        <div class="user-info">
            <span>Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 15px;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <div class="container">
        {{-- Mensajes --}}
        @if(session('success'))
            <div class="alert-box alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error') || isset($error))
            <div class="alert-box alert-error">⚠️ {{ session('error') ?? $error }}</div>
        @endif

        {{-- Menú de Navegación (SIN Vehículos ni Conductores) --}}
        <div class="menu-nav">
            <a href="{{ route('conductor.mis-turnos') }}">📅 Mis Turnos</a>
            <a href="{{ route('conductor.alertas') }}">⚠️ Alertas</a>
            <a href="{{ route('conductor.solicitudes-cambio-ruta') }}">📝 Solicitudes Ruta</a>
            <a href="{{ route('conductor.tarifas') }}">💰 Tarifas</a>
            <a href="{{ route('conductor.mantenimiento-general') }}">🔧 Mantenimientos</a>
        </div>

        {{-- Información del conductor --}}
        @if(isset($conductor) && $conductor)
            <div class="info-conductor">
                <strong>📋 Mi Información</strong><br><br>
                <strong>Nombre:</strong> {{ $conductor->primer_nombre }} {{ $conductor->primer_apellido }}<br>
                <strong>Documento:</strong> {{ $conductor->tipo_documento }} {{ $conductor->numero_documento }}<br>
                <strong>Licencia:</strong> {{ $conductor->numero_licencia }} - Categoría {{ $conductor->categoria_licencia }}<br>
                <strong>Celular:</strong> {{ $conductor->celular }}<br>
                <strong>Estado:</strong> <span style="color: {{ $conductor->estado == 'activo' ? '#2e7d32' : '#c62828' }}; font-weight: bold;">{{ ucfirst($conductor->estado) }}</span>
            </div>
        @endif

        {{-- Estadísticas --}}
        <div class="stats-grid">
            <div class="stat-card">
                <h3>📅 Turnos Próximos</h3>
                <div class="number">{{ isset($turnosProximos) ? $turnosProximos->count() : 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>📝 Solicitudes Pendientes</h3>
                <div class="number">{{ $solicitudesPendientes ?? 0 }}</div>
            </div>
            <div class="stat-card alertas">
                <h3>⚠️ Alertas Sin Resolver</h3>
                <div class="number">{{ isset($alertas) ? $alertas->count() : 0 }}</div>
            </div>
        </div>

        {{-- Turnos Próximos --}}
        <div class="section">
            <h2>📅 Mis Próximos Turnos</h2>
            @if(isset($turnosProximos) && $turnosProximos->count() > 0)
                @foreach($turnosProximos as $turno)
                    <div class="turno-item">
                        <strong>📆 Fecha:</strong> {{ \Carbon\Carbon::parse($turno->fecha_turno)->format('d/m/Y') }}<br>
                        <strong>🚐 Vehículo:</strong> {{ $turno->vehiculo->placa ?? 'N/A' }} - {{ $turno->vehiculo->marca ?? '' }} {{ $turno->vehiculo->modelo ?? '' }}<br>
                        <strong>🔢 Número Móvil:</strong> {{ $turno->vehiculo->numero_interno ?? 'N/A' }}<br>
                        <strong>📊 Estado:</strong> {{ ucfirst($turno->estado ?? 'programado') }}
                    </div>
                @endforeach
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ route('conductor.mis-turnos') }}" style="color: #00695c; font-weight: bold;">Ver todos mis turnos →</a>
                </div>
            @else
                <div class="empty-state">
                    <div class="icon">📅</div>
                    <p>No tienes turnos programados próximamente.</p>
                </div>
            @endif
        </div>

        {{-- Alertas --}}
        @if(isset($alertas) && $alertas->count() > 0)
            <div class="section">
                <h2>⚠️ Mis Alertas Pendientes</h2>
                @foreach($alertas as $alerta)
                    <div class="alerta-item {{ strtolower($alerta->prioridad) }}">
                        <strong>{{ $alerta->titulo }}</strong>
                        <span class="badge {{ strtolower($alerta->prioridad) }}">{{ ucfirst($alerta->prioridad) }}</span><br>
                        <p style="margin: 10px 0;">{{ $alerta->descripcion }}</p>
                        <small style="color: #666;">📅 {{ \Carbon\Carbon::parse($alerta->fecha_alerta)->format('d/m/Y H:i') }}</small>
                    </div>
                @endforeach
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ route('conductor.alertas') }}" style="color: #00695c; font-weight: bold;">Ver todas las alertas →</a>
                </div>
            </div>
        @endif
    </div>
</body>
</html>