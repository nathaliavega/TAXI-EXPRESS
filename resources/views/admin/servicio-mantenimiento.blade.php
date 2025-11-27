<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios de Mantenimiento - Admin</title>
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
        
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        
        .header-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-section h2 { color: #ff6b35; font-size: 24px; }
        .btn-back {
            background: #718096;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-back:hover { background: #4a5568; }
        
        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-collapse: collapse;
        }
        table th {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            padding: 15px;
            text-align: left;
            font-size: 14px;
        }
        table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        table tr:hover { background: #fff5f0; }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge.success { background: #38a169; color: white; }
        .badge.info { background: #805ad5; color: white; }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .pagination a, .pagination span {
            padding: 8px 15px;
            background: white;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }
        .pagination .active { background: #ff6b35; color: white; }
        
        .empty-state {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 10px;
            color: #888;
        }
        .empty-state .icon { font-size: 60px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🔧 Servicios de Mantenimiento - Taxi Express</h1>
        
    </div>

    <div class="container">
        <div class="header-section">
            <h2>📋 Historial de Mantenimientos</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← Volver al Dashboard</a>
        </div>

        @if($servicios->count() > 0)
            <table>
                <thead>
                    <tr>
                        
                        <th>Vehículo</th>
                        <th>Tipo Mantenimiento</th>
                        <th>Fecha</th>
                        <th>Costo</th>
                        <th>Taller</th>
                        <th>Realizado Por</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $servicio)
                        <tr>
                            
                            <td>
                                <strong>{{ $servicio->vehiculo->placa ?? 'N/A' }}</strong><br>
                                <small>{{ $servicio->vehiculo->marca ?? '' }} {{ $servicio->vehiculo->modelo ?? '' }}</small>
                            </td>
                            <td>
                                <span class="badge info">{{ $servicio->mantenimientoGeneral->nombre ?? 'N/A' }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($servicio->fecha_mantenimiento)->format('d/m/Y') }}</td>
                            <td><strong style="color: #38a169;">${{ number_format($servicio->costo ?? 0, 0, ',', '.') }}</strong></td>
                            <td>{{ $servicio->taller ?? 'N/A' }}</td>
                            <td>{{ $servicio->realizado_por ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                {{ $servicios->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="icon">🔧</div>
                <h3>No hay servicios de mantenimiento registrados</h3>
                <p>Los mantenimientos realizados aparecerán aquí</p>
            </div>
        @endif
    </div>
</body>
</html>