<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos de Mantenimiento - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        
        .navbar {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 { 
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-logout {
            background: white;
            color: #ff6b35;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-logout:hover { background: #f0f0f0; }
        
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        
        .header-section {
            background: white;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-section h2 { 
            color: #ff6b35; 
            font-size: 26px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-back {
            background: #5a6c7d;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-back:hover { 
            background: #4a5568;
            transform: translateY(-2px);
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead {
            background: linear-gradient(135deg, #ff6b35, #f7931e);
        }
        table th {
            color: white;
            padding: 18px 20px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table tbody tr {
            border-bottom: 1px solid #eee;
            transition: all 0.2s ease;
        }
        table tbody tr:hover { 
            background: #fff5f0;
            transform: scale(1.01);
        }
        table td {
            padding: 18px 20px;
            font-size: 14px;
            color: #333;
        }
        
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge.preventivo { background: #3182ce; color: white; }
        .badge.correctivo { background: #dd6b20; color: white; }
        .badge.activo { background: #38a169; color: white; }
        .badge.inactivo { background: #718096; color: white; }
        .badge.kilometraje { background: #805ad5; color: white; }
        .badge.na { background: #e2e8f0; color: #4a5568; }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }
        .empty-state .icon { font-size: 64px; margin-bottom: 20px; }
        .empty-state h3 { font-size: 20px; margin-bottom: 10px; color: #666; }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            background: white;
            border-radius: 0 0 10px 10px;
        }
        .pagination a, .pagination span {
            padding: 10px 16px;
            background: #f7f7f7;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .pagination a:hover {
            background: #ff6b35;
            color: white;
        }
        .pagination .active { 
            background: #ff6b35; 
            color: white;
        }
        
        @media (max-width: 768px) {
            .navbar { flex-direction: column; gap: 15px; }
            .header-section { flex-direction: column; gap: 15px; text-align: center; }
            table { font-size: 12px; }
            table th, table td { padding: 12px 10px; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>🔧 Servicios de Mantenimiento - Taxi Express</h1>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-logout">Cerrar Sesión</button>
        </form>
    </div>

    <div class="container">
        <div class="header-section">
            <h2>📋 Catálogo de Tipos de Mantenimiento</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn-back">← Volver al Dashboard</a>
        </div>

        @if($mantenimientos->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Kilometraje Recomendado</th>
                            <th>Cambio Neumáticos</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mantenimientos as $mantenimiento)
                            <tr>
                                <td><strong>#{{ $mantenimiento->id_mantenimiento_general }}</strong></td>
                                <td><strong>{{ $mantenimiento->nombre }}</strong></td>
                                <td>{{ Str::limit($mantenimiento->descripcion ?? 'Sin descripción', 80) }}</td>
                                <td>
                                    @if($mantenimiento->kilometraje_recomendado)
                                        <span class="badge kilometraje">{{ number_format($mantenimiento->kilometraje_recomendado, 0, ',', '.') }} km</span>
                                    @else
                                        <span class="badge na">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($mantenimiento->cambio_neumaticos)
                                        <span class="badge correctivo">{{ number_format($mantenimiento->cambio_neumaticos, 0, ',', '.') }} km</span>
                                    @else
                                        <span class="badge na">No aplica</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $mantenimiento->es_preventivo ? 'preventivo' : 'correctivo' }}">
                                        {{ $mantenimiento->es_preventivo ? 'Preventivo' : 'Correctivo' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $mantenimiento->activo ? 'activo' : 'inactivo' }}">
                                        {{ $mantenimiento->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($mantenimientos->hasPages())
                    <div class="pagination">
                        {{ $mantenimientos->links() }}
                    </div>
                @endif
            </div>
        @else
            <div class="table-container">
                <div class="empty-state">
                    <div class="icon">📋</div>
                    <h3>No hay tipos de mantenimiento registrados</h3>
                    <p>Los tipos de mantenimiento disponibles aparecerán aquí</p>
                </div>
            </div>
        @endif
    </div>
</body>
</html>