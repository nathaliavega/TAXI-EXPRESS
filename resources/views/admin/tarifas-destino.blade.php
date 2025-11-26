<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifas de Destino - Taxi Express</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        /* Estadísticas Cards */
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #ff6b35;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: #ff6b35;
            flex-shrink: 0;
        }

        .stats-content {
            flex: 1;
        }

        .stats-label {
            margin: 0;
            font-size: 0.7rem;
            font-weight: 600;
            color: #9ca3af;
            letter-spacing: 0.5px;
        }

        .stats-value {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1;
        }

        /* Card principal */
        .card {
            border-radius: 8px;
            overflow: hidden;
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        /* Tabla */
        .table thead tr th {
            background: #f9fafb;
            font-weight: 600;
            font-size: 0.7rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e5e7eb;
            padding: 1rem;
        }

        .table tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }

        .table tbody tr:hover {
            background-color: #fef3f0;
        }

        .table tbody tr td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Badge de estado */
        .badge-status {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-status.active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status.inactive {
            background: #e5e7eb;
            color: #6b7280;
        }

        .badge-status.large {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* Botones de acción */
        .action-buttons {
            display: flex;
            gap: 0.375rem;
            justify-content: center;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            background: white;
            color: #ff6b35;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-action:hover {
            background: #ff6b35;
            color: white;
            border-color: #ff6b35;
        }

        /* Modales */
        .modal-content {
            border-radius: 8px;
            border: none;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: none;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: none;
        }

        /* Detalles en modal */
        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        /* Formularios */
        .form-control, .form-select {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 0.625rem 0.875rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        /* Botones */
        .btn {
            border-radius: 6px;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
        }

        .btn-orange {
            background: #ff6b35;
            color: white;
        }

        .btn-orange:hover {
            background: #e55a28;
            color: white;
        }

        .btn-light {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            color: #6b7280;
        }

        .btn-light:hover {
            background: #e5e7eb;
            color: #374151;
        }

        .text-orange {
            color: #ff6b35 !important;
        }

        /* Badge pill */
        .badge.bg-primary {
            background-color: #ff6b35 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-card {
                padding: 1rem;
            }
            
            .stats-icon {
                width: 45px;
                height: 45px;
                font-size: 1.25rem;
            }
            
            .stats-value {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4 py-4">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 fw-bold text-dark">🔖 Tarifas de Destino</h1>
                <p class="text-muted mb-0">Administra las tarifas y destinos disponibles</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button type="button" class="btn btn-orange" data-bs-toggle="modal" data-bs-target="#modalNuevaTarifa">
                    <i class="fas fa-plus"></i> Nueva Tarifa
                </button>
            </div>
        </div>

        <!-- Mensajes de éxito/error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Estadísticas -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <div class="stats-content">
                        <p class="stats-label">TOTAL DESTINOS</p>
                        <h2 class="stats-value">{{ $tarifas->total() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <p class="stats-label">TARIFAS ACTIVAS</p>
                        <h2 class="stats-value">{{ $tarifas->where('activa', true)->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <p class="stats-label">TARIFA PROMEDIO</p>
                        <h2 class="stats-value">${{ number_format($tarifas->avg('tarifa_base'), 0) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <div class="stats-content">
                        <p class="stats-label">CIUDADES</p>
                        <h2 class="stats-value">{{ $tarifas->unique('ciudad')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.tarifas-destino') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Búsqueda</label>
                            <input type="text" name="buscar" class="form-control" placeholder="Buscar destino o ciudad..." value="{{ request('buscar') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small">Departamento</label>
                            <select name="departamento" class="form-select">
                                <option value="">Todos</option>
                                <option value="Santander" {{ request('departamento') == 'Santander' ? 'selected' : '' }}>Santander</option>
                                <option value="Norte de Santander" {{ request('departamento') == 'Norte de Santander' ? 'selected' : '' }}>Norte de Santander</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small">Estado</label>
                            <select name="activa" class="form-select">
                                <option value="">Todos</option>
                                <option value="1" {{ request('activa') === '1' ? 'selected' : '' }}>Activas</option>
                                <option value="0" {{ request('activa') === '0' ? 'selected' : '' }}>Inactivas</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small">Tarifa Desde</label>
                            <input type="number" name="tarifa_min" class="form-control" placeholder="Min" value="{{ request('tarifa_min') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small">Tarifa Hasta</label>
                            <input type="number" name="tarifa_max" class="form-control" placeholder="Max" value="{{ request('tarifa_max') }}">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-orange w-100">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Tarifas -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-orange">
                        <i class="fas fa-list me-2"></i>Lista de Tarifas y Destinos
                    </h6>
                    <span class="badge bg-primary rounded-pill">{{ $tarifas->total() }} registros</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="px-4 text-muted small">ID</th>
                                <th class="text-muted small">DESTINO</th>
                                <th class="text-muted small">CIUDAD</th>
                                <th class="text-muted small">DEPARTAMENTO</th>
                                <th class="text-muted small text-end">TARIFA BASE</th>
                                <th class="text-muted small">VIGENCIA</th>
                                <th class="text-muted small text-center">ESTADO</th>
                                <th class="text-muted small text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tarifas as $tarifa)
                                <tr>
                                    <td class="px-4 text-muted">{{ $tarifa->id_tarifa }}</td>
                                    <td><strong class="text-dark">{{ $tarifa->nombre_destino }}</strong></td>
                                    <td>{{ $tarifa->ciudad }}</td>
                                    <td>{{ $tarifa->departamento }}</td>
                                    <td class="text-end">
                                        <strong class="text-success">${{ number_format($tarifa->tarifa_base, 0) }}</strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_desde)->format('d/m/Y') }}
                                            @if($tarifa->fecha_vigencia_hasta)
                                                - {{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_hasta)->format('d/m/Y') }}
                                            @endif
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @if($tarifa->activa)
                                            <span class="badge-status active">Activa</span>
                                        @else
                                            <span class="badge-status inactive">Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <button type="button" class="btn-action" data-bs-toggle="modal" data-bs-target="#verTarifa{{ $tarifa->id_tarifa }}" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action" data-bs-toggle="modal" data-bs-target="#editarTarifa{{ $tarifa->id_tarifa }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.tarifas-destino', $tarifa->id_tarifa) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-action" title="{{ $tarifa->activa ? 'Desactivar' : 'Activar' }}">
                                                    <i class="fas fa-{{ $tarifa->activa ? 'ban' : 'check' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Ver Tarifa -->
                                <div class="modal fade" id="verTarifa{{ $tarifa->id_tarifa }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content shadow-lg">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">
                                                    <i class="fas fa-info-circle text-orange me-2"></i>Detalle de Tarifa #{{ $tarifa->id_tarifa }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-4">
                                                    <div class="col-12">
                                                        @if($tarifa->activa)
                                                            <span class="badge-status active large">Tarifa Activa</span>
                                                        @else
                                                            <span class="badge-status inactive large">Tarifa Inactiva</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="detail-label">Nombre del Destino</label>
                                                        <p class="detail-value">{{ $tarifa->nombre_destino }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Ciudad</label>
                                                        <p class="detail-value">{{ $tarifa->ciudad }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Departamento</label>
                                                        <p class="detail-value">{{ $tarifa->departamento }}</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="detail-label">Tarifa Base</label>
                                                        <p class="detail-value text-success" style="font-size: 2rem;">${{ number_format($tarifa->tarifa_base, 0) }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Fecha Inicio</label>
                                                        <p class="detail-value">{{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_desde)->format('d/m/Y') }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Fecha Fin</label>
                                                        <p class="detail-value">
                                                            @if($tarifa->fecha_vigencia_hasta)
                                                                {{ \Carbon\Carbon::parse($tarifa->fecha_vigencia_hasta)->format('d/m/Y') }}
                                                            @else
                                                                <span class="text-success">Sin fecha límite</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-orange" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editarTarifa{{ $tarifa->id_tarifa }}">
                                                    <i class="fas fa-edit me-1"></i>Editar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Editar Tarifa -->
                                <div class="modal fade" id="editarTarifa{{ $tarifa->id_tarifa }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow-lg">
                                            <form action="{{ route('admin.tarifas-destino', $tarifa->id_tarifa) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">
                                                        <i class="fas fa-edit text-orange me-2"></i>Editar Tarifa
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Nombre del Destino <span class="text-danger">*</span></label>
                                                        <input type="text" name="nombre_destino" class="form-control" value="{{ $tarifa->nombre_destino }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Ciudad <span class="text-danger">*</span></label>
                                                        <input type="text" name="ciudad" class="form-control" value="{{ $tarifa->ciudad }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Departamento <span class="text-danger">*</span></label>
                                                        <input type="text" name="departamento" class="form-control" value="{{ $tarifa->departamento }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Tarifa Base <span class="text-danger">*</span></label>
                                                        <input type="number" name="tarifa_base" class="form-control" value="{{ $tarifa->tarifa_base }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-semibold">Fecha Inicio <span class="text-danger">*</span></label>
                                                            <input type="date" name="fecha_vigencia_desde" class="form-control" value="{{ $tarifa->fecha_vigencia_desde }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label fw-semibold">Fecha Fin</label>
                                                            <input type="date" name="fecha_vigencia_hasta" class="form-control" value="{{ $tarifa->fecha_vigencia_hasta }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label fw-semibold">Estado</label>
                                                        <select name="activa" class="form-select">
                                                            <option value="1" {{ $tarifa->activa ? 'selected' : '' }}>Activa</option>
                                                            <option value="0" {{ !$tarifa->activa ? 'selected' : '' }}>Inactiva</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-orange">
                                                        <i class="fas fa-save me-1"></i>Guardar Cambios
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No se encontraron tarifas</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            @if($tarifas->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-center">
                    {{ $tarifas->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Nueva Tarifa -->
    <div class="modal fade" id="modalNuevaTarifa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <form action="{{ route('admin.tarifas-destino') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-plus-circle text-orange me-2"></i>Nueva Tarifa de Destino
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre del Destino <span class="text-danger">*</span></label>
                            <input type="text" name="nombre_destino" class="form-control" placeholder="Ej: San Gil Centro" required>
                            <small class="text-muted">Nombre descriptivo del destino</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ciudad <span class="text-danger">*</span></label>
                            <input type="text" name="ciudad" class="form-control" placeholder="Ej: San Gil" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Departamento <span class="text-danger">*</span></label>
                            <input type="text" name="departamento" class="form-control" placeholder="Ej: Santander" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tarifa Base <span class="text-danger">*</span></label>
                            <input type="number" name="tarifa_base" class="form-control" placeholder="Ej: 450000" required>
                            <small class="text-muted">Tarifa en pesos colombianos</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Fecha Inicio <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_vigencia_desde" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-0">
                                <label class="form-label fw-semibold">Fecha Fin</label>
                                <input type="date" name="fecha_vigencia_hasta" class="form-control">
                                <small class="text-muted">Opcional</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-orange">
                            <i class="fas fa-save me-1"></i>Guardar Tarifa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>