<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Conductor - TAXI EXPRESS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #00bcd4 0%, #00acc1 100%);
            color: white;
            padding: 20px 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 20px;
            border: 2px solid white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: white;
            color: #00bcd4;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 40px;
        }

        /* Tarjeta de información del conductor */
        .conductor-info {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .conductor-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #00bcd4 0%, #00acc1 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            font-weight: bold;
            flex-shrink: 0;
        }

        .conductor-details {
            flex: 1;
        }

        .conductor-name {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .conductor-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #333;
        }

        /* Tarjetas de estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-icon.pending {
            background: #fff3e0;
        }

        .stat-icon.approved {
            background: #e8f5e9;
        }

        .stat-icon.rejected {
            background: #ffebee;
        }

        .stat-icon.total {
            background: #e3f2fd;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #333;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Sección de últimas solicitudes */
        .recent-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .solicitud-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .solicitud-item:last-child {
            border-bottom: none;
        }

        .solicitud-info {
            flex: 1;
        }

        .solicitud-contratante {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .solicitud-direcciones {
            font-size: 14px;
            color: #666;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.pendiente {
            background: #fff3e0;
            color: #f57c00;
        }

        .badge.aprobado {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge.rechazado {
            background: #ffebee;
            color: #c62828;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        /* Botones de acción rápida */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .action-btn {
            background: white;
            border: 2px solid #00bcd4;
            color: #00bcd4;
            padding: 15px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .action-btn:hover {
            background: #00bcd4;
            color: white;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .conductor-info {
                flex-direction: column;
                text-align: center;
            }

            .conductor-info-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <span style="font-size: 32px;">🚖</span>
            <h1 class="header-title">Dashboard - Conductor</h1>
        </div>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout" style="background: rgba(255, 255, 255, 0.2); cursor: pointer;">
                Cerrar Sesión
            </button>
        </form>
    </div>

    <div class="container">
        <!-- Información del Conductor -->
        <div class="conductor-info">
            <div class="conductor-avatar">
                {{ strtoupper(substr($conductor->primer_nombre ?? 'C', 0, 1)) }}{{ strtoupper(substr($conductor->primer_apellido ?? 'D', 0, 1)) }}
            </div>
            <div class="conductor-details">
                <h2 class="conductor-name">
                    {{ $conductor->primer_nombre ?? '' }} 
                    {{ $conductor->segundo_nombre ?? '' }} 
                    {{ $conductor->primer_apellido ?? '' }} 
                    {{ $conductor->segundo_apellido ?? '' }}
                </h2>
                <div class="conductor-info-grid">
                    <div class="info-item">
                        <span class="info-label">📄 Documento:</span>
                        <span class="info-value">{{ $conductor->tipo_documento ?? 'CC' }} {{ $conductor->numero_documento ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">📞 Teléfono:</span>
                        <span class="info-value">{{ $conductor->telefono ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">📧 Email:</span>
                        <span class="info-value">{{ $conductor->email ?? $usuario->email ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">👤 Usuario:</span>
                        <span class="info-value">{{ $usuario->nombre_usuario ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="quick-actions">
            <a href="{{ route('conductor.solicitudes-cambio-ruta') }}" class="action-btn">
                ➕ Nueva Solicitud
            </a>
            <a href="{{ route('conductor.mis-turnos') }}" class="action-btn">
                📅 Mis Turnos
            </a>
            <a href="{{ route('conductor.vehiculos') }}" class="action-btn">
                🚗 Vehículos
            </a>
            <a href="{{ route('conductor.tarifas') }}" class="action-btn">
                💰 Tarifas
            </a>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon pending">⏳</div>
                </div>
                <div class="stat-number">{{ $estadisticas['solicitudes_pendientes'] }}</div>
                <div class="stat-label">Solicitudes Pendientes</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon approved">✅</div>
                </div>
                <div class="stat-number">{{ $estadisticas['solicitudes_aprobadas'] }}</div>
                <div class="stat-label">Solicitudes Aprobadas</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon rejected">❌</div>
                </div>
                <div class="stat-number">{{ $estadisticas['solicitudes_rechazadas'] }}</div>
                <div class="stat-label">Solicitudes Rechazadas</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon total">📊</div>
                </div>
                <div class="stat-number">{{ $estadisticas['total_solicitudes'] }}</div>
                <div class="stat-label">Total Solicitudes</div>
            </div>
        </div>

        <!-- Últimas Solicitudes -->
        <div class="recent-section">
            <h3 class="section-title">
                📋 Últimas Solicitudes
            </h3>
            @if($ultimasSolicitudes->count() > 0)
                @foreach($ultimasSolicitudes as $solicitud)
                <div class="solicitud-item">
                    <div class="solicitud-info">
                        <div class="solicitud-contratante">{{ $solicitud->nombre_contratante }}</div>
                        <div class="solicitud-direcciones">
                            📍 {{ Str::limit($solicitud->direccion_origen, 50) }} → {{ Str::limit($solicitud->direccion_destino, 50) }}
                        </div>
                        <div style="font-size: 12px; color: #999; margin-top: 5px;">
                            {{ $solicitud->fecha_solicitud->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <span class="badge {{ $solicitud->estado }}">{{ ucfirst($solicitud->estado) }}</span>
                </div>
                @endforeach
            @else
                <div class="no-data">
                    No hay solicitudes registradas
                </div>
            @endif
        </div>
    </div>
</body>
</html>