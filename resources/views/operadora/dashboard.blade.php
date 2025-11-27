<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Operadora</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .navbar {
            background: linear-gradient(135deg, #9c27b0, #e91e63);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 24px;
        }
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-logout {
            background: white;
            color: #9c27b0;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-logout:hover {
            background: #f0f0f0;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
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
        }
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #9c27b0;
        }
        .turnos-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .turnos-section h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .turno-item {
            padding: 15px;
            border-left: 4px solid #9c27b0;
            margin-bottom: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .turno-item strong {
            color: #333;
        }
        .menu-links {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .menu-links a {
            padding: 10px 20px;
            background: #9c27b0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu-links a:hover {
            background: #7b1fa2;
        }
        .success-message {
            padding: 15px;
            background: #d4edda;
            color: #155724;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            padding: 15px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-left: 5px;
        }
        .badge.programado {
            background: #2196F3;
            color: white;
        }
        .badge.cumplido {
            background: #4CAF50;
            color: white;
        }
        .badge.incumplido {
            background: #f44336;
            color: white;
        }
        .badge.justificado {
            background: #FF9800;
            color: white;
        }
        .badge.cancelado {
            background: #9E9E9E;
            color: white;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Panel de Operadora - Taxi Express Pamplona</h1>
        <div class="user-info">
            <span>Bienvenida, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <div class="menu-links">
            <a href="{{ route('operadora.vehiculos') }}">Vehículos</a>
            <a href="{{ route('operadora.control-turnos') }}">Control de Turnos</a>
            <a href="{{ route('operadora.turnos-obligatorios') }}">Turnos Obligatorios</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Turnos de Hoy</h3>
                <div class="number">{{ $turnosHoy ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>Vehículos Activos</h3>
                <div class="number">{{ $vehiculosActivos ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>Turnos Pendientes</h3>
                <div class="number">{{ $turnosPendientes ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>Turnos Completados</h3>
                <div class="number">{{ $turnosCompletados ?? 0 }}</div>
            </div>
        </div>

        <div class="turnos-section">
            <h2>Turnos Recientes</h2>
            @forelse($turnosRecientes ?? [] as $turno)
                <div class="turno-item">
                    <strong>Vehículo:</strong> {{ $turno->vehiculo->placa ?? 'N/A' }} - Móvil {{ $turno->vehiculo->numero_interno ?? 'N/A' }}<br>
                    <strong>Conductor:</strong> {{ $turno->conductor->primer_nombre ?? 'N/A' }} {{ $turno->conductor->primer_apellido ?? '' }}<br>
                    <strong>Fecha:</strong> {{ $turno->fecha_turno ? \Carbon\Carbon::parse($turno->fecha_turno)->format('d/m/Y') : 'N/A' }}<br>
                    <strong>Estado:</strong> <span class="badge {{ $turno->estado }}">{{ ucfirst($turno->estado ?? 'programado') }}</span>
                </div>
            @empty
                <p style="text-align: center; color: #666; padding: 20px;">No hay turnos recientes.</p>
            @endforelse
        </div>
    </div>
</body>
</html>