<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas de Destino</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .page-header {
            background: white;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Tarjetas simples */
        .stat-box {
            background: white;
            padding: 1.25rem;
            border-radius: 8px;
            border-left: 3px solid #ff6b35;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            margin: 0;
        }

        /* Filtros */
        .filters-box {
            background: white;
            padding: 1.25rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        /* Tabla */
        .table-box {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #e9ecef;
        }

        .table thead th {
            background: #f8f9fa;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            padding: 0.875rem;
            border: none;
        }

        .table tbody td {
            padding: 0.875rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f5;
        }

        .table tbody tr:hover {
            background: #fff8f6;
        }

        /* Badges simples */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #e2e3e5;
            color: #6c757d;
        }

        /* Botones simples */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .btn-orange {
            background: #ff6b35;
            color: white;
            border: none;
        }

        .btn-orange:hover {
            background: #e55a28;
            color: white;
        }

        .btn-light {
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Acciones */
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            border: 1px solid #dee2e6;
            background: white;
            color: #ff6b35;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }

        .action-btn:hover {
            background: #ff6b35;
            color: white;
            border-color: #ff6b35;
        }

        /* Formularios */
        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.15);
        }

        /* Modal simple */
        .modal-content {
            border: none;
            border-radius: 8px;
        }

        .modal-header {
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.25rem;
        }

        .detail-row {
            margin-bottom: 1rem;
        }

        .detail-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #212529;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4 py-4">
        
        <!-- Encabezado -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1 fw-bold">Tarifas de Destino</h4>
                    <p class="text-muted mb-0 small">Gestión de tarifas y destinos</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <button class="btn btn-orange btn-sm" data-bs-toggle="modal" data-bs-target="#nuevaTarifa">
                        <i class="fas fa-plus"></i> Nueva Tarifa
                    </button>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-label">Total Destinos</div>
                    <h2 class="stat-number">{{ $tarifas->total() }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-label">Tarifas Activas</div>
                    <h2 class="stat-number">{{ $tarifas->where('activa', true)->count() }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-label">Tarifa Promedio</div>
                    <h2 class="stat-number">${{ number_format($tarifas->avg('tarifa_base'), 0) }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <div class="stat-label">Ciudades</div>
                    <h2 class="stat-number">{{ $tarifas->unique('ciudad')->count() }}</h2>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-box">
            <form method="GET" action="{{ route('admin.tarifas-destino') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small mb-1">Búsqueda</label>
                        <input type="text" name="buscar" class="form-control form-control-sm" placeholder="Buscar..." value="{{ request('buscar') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Departamento</label>
                        <select name="departamento" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="Santander" {{ request('departamento') == 'Santander' ? 'selected' : '' }}>Santander</option>
                            <option value="Norte de Santander" {{ request('departamento') == 'Norte de Santander' ? 'selected' : '' }}>Norte de Santander</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Estado</label>
                        <select name="activa" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <option value="1" {{ request('activa') === '1' ? 'selected' : '' }}>Activas</option>
                            <option value="0" {{ request('activa') === '0' ? 'selected' : '' }}>Inactivas</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Tarifa Min</label>
                        <input type="number" name="tarifa_min" class="form-control form-control-sm" value="{{ request('tarifa_min') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small mb-1">Tarifa Max</label>
                        <input type="number" name="tarifa_max" class="form-control form-control-sm" value="{{ request('tarifa_max') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-orange btn-sm w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tabla -->
        <div class="table-box">
            <div class="table-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Lista de Tarifas</h6>
                <span class="badge bg-secondary">{{ $tarifas->total() }} registros</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Destino</th>
                            <th>Ciudad</th>
                            <th>Departamento</th>
                            <th class="text-end">Tarifa</th>
                            <th>Vigencia</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tarifas as $tarifa)
                            <tr>
                                <td class="text-muted">{{ $tarifa->id_tarifa }}</td>
                                <td><strong>{{ $tarifa->nombre_destino }}</strong></td>
                                <td>{{ $tarifa->ciudad }}</td>
                                <td>{{ $tarifa->departamento }}</td>
                                <td class="text-end"><strong class="text-success">${{ number_format($tarifa->tarifa_base, 0) }}</strong></td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_desde)->format('d/m/Y') }}
                                        @if($tarifa->fecha_vigencia_hasta)
                                            - {{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_hasta)->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge {{ $tarifa->activa ? 'status-active' : 'status-inactive' }}">
                                        {{ $tarifa->activa ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="action-btn" data-bs-toggle="modal" data-bs-target="#ver{{ $tarifa->id_tarifa }}" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" data-bs-toggle="modal" data-bs-target="#editar{{ $tarifa->id_tarifa }}" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.tarifas-destino', $tarifa->id_tarifa) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn" title="{{ $tarifa->activa ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-{{ $tarifa->activa ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Ver -->
                            <div class="modal fade" id="ver{{ $tarifa->id_tarifa }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Detalle Tarifa #{{ $tarifa->id_tarifa }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <span class="status-badge {{ $tarifa->activa ? 'status-active' : 'status-inactive' }}">
                                                    {{ $tarifa->activa ? 'Activa' : 'Inactiva' }}
                                                </span>
                                            </div>
                                            <div class="detail-row">
                                                <div class="detail-label">Destino</div>
                                                <div class="detail-value">{{ $tarifa->nombre_destino }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="detail-row">
                                                        <div class="detail-label">Ciudad</div>
                                                        <div class="detail-value">{{ $tarifa->ciudad }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="detail-row">
                                                        <div class="detail-label">Departamento</div>
                                                        <div class="detail-value">{{ $tarifa->departamento }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="detail-row">
                                                <div class="detail-label">Tarifa Base</div>
                                                <div class="detail-value text-success" style="font-size: 1.5rem;">${{ number_format($tarifa->tarifa_base, 0) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="detail-row">
                                                        <div class="detail-label">Inicio</div>
                                                        <div class="detail-value">{{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_desde)->format('d/m/Y') }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="detail-row">
                                                        <div class="detail-label">Fin</div>
                                                        <div class="detail-value">
                                                            @if($tarifa->fecha_vigencia_hasta)
                                                                {{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_hasta)->format('d/m/Y') }}
                                                            @else
                                                                <span class="text-success">Sin límite</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="button" class="btn btn-orange btn-sm" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editar{{ $tarifa->id_tarifa }}">
                                                Editar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Editar -->
                            <div class="modal fade" id="editar{{ $tarifa->id_tarifa }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.tarifas-destino', $tarifa->id_tarifa) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Editar Tarifa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre del Destino *</label>
                                                    <input type="text" name="nombre_destino" class="form-control" value="{{ $tarifa->nombre_destino }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Ciudad *</label>
                                                    <input type="text" name="ciudad" class="form-control" value="{{ $tarifa->ciudad }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Departamento *</label>
                                                    <input type="text" name="departamento" class="form-control" value="{{ $tarifa->departamento }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tarifa Base *</label>
                                                    <input type="number" name="tarifa_base" class="form-control" value="{{ $tarifa->tarifa_base }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Fecha Inicio *</label>
                                                        <input type="date" name="fecha_vigencia_desde" class="form-control" value="{{ $tarifa->fecha_vigencia_desde }}" required>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Fecha Fin</label>
                                                        <input type="date" name="fecha_vigencia_hasta" class="form-control" value="{{ $tarifa->fecha_vigencia_hasta }}">
                                                    </div>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label">Estado</label>
                                                    <select name="activa" class="form-select">
                                                        <option value="1" {{ $tarifa->activa ? 'selected' : '' }}>Activa</option>
                                                        <option value="0" {{ !$tarifa->activa ? 'selected' : '' }}>Inactiva</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-orange btn-sm">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <p class="text-muted mb-0">No hay tarifas registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($tarifas->hasPages())
            <div class="p-3 border-top">
                {{ $tarifas->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Nueva Tarifa -->
    <div class="modal fade" id="nuevaTarifa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.tarifas-destino') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Nueva Tarifa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Destino *</label>
                            <input type="text" name="nombre_destino" class="form-control" placeholder="Ej: San Gil Centro" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ciudad *</label>
                            <input type="text" name="ciudad" class="form-control" placeholder="Ej: San Gil" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Departamento *</label>
                            <input type="text" name="departamento" class="form-control" placeholder="Ej: Santander" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tarifa Base *</label>
                            <input type="number" name="tarifa_base" class="form-control" placeholder="Ej: 450000" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Fecha Inicio *</label>
                                <input type="date" name="fecha_vigencia_desde" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" name="fecha_vigencia_hasta" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-orange btn-sm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>