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
        .badge-price {
            padding: 0.35rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 700;
            background: #d1fae5;
            color: #065f46;
        }

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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabla -->
        <div class="table-box">
            <div class="table-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Lista de Tarifas</h6>
                <span class="badge bg-secondary">{{ $tarifas->count() }} registros</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
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
                                <td><strong>{{ $tarifa->nombre_destino }}</strong></td>
                                <td>{{ $tarifa->ciudad }}</td>
                                <td>{{ $tarifa->departamento }}</td>
                                <td class="text-end">
                                    <span class="badge-price">${{ number_format($tarifa->tarifa_base, 0) }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($tarifa->fecha_inicio)->format('d/m/Y') }}
                                        @if($tarifa->fecha_fin)
                                            - {{ \Carbon\Carbon::parse($tarifa->fecha_fin)->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="status-badge {{ $tarifa->estado == 'Activa' ? 'status-active' : 'status-inactive' }}">
                                        {{ $tarifa->estado }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="action-btn" data-bs-toggle="modal" data-bs-target="#ver{{ $tarifa->id_tarifa }}" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn" data-bs-toggle="modal" data-bs-target="#editar{{ $tarifa->id_tarifa }}" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.tarifas-destino.destroy', $tarifa->id_tarifa) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta tarifa?')">
                                            <i class="fas fa-trash"></i>
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
                                                <span class="status-badge {{ $tarifa->estado == 'Activa' ? 'status-active' : 'status-inactive' }}">
                                                    {{ $tarifa->estado }}
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
                                                <div class="detail-value">
                                                    <span class="badge-price" style="font-size: 1.5rem; padding: 0.5rem 1rem;">${{ number_format($tarifa->tarifa_base, 0) }}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="detail-row">
                                                        <div class="detail-label">Inicio</div>
                                                        <div class="detail-value">{{ \Carbon\Carbon::parse($tarifa->fecha_inicio)->format('d/m/Y') }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="detail-row">
                                                        <div class="detail-label">Fin</div>
                                                        <div class="detail-value">
                                                            @if($tarifa->fecha_fin)
                                                                {{ \Carbon\Carbon::parse($tarifa->fecha_fin)->format('d/m/Y') }}
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
                                        <form action="{{ route('admin.tarifas-destino.update', $tarifa->id_tarifa) }}" method="POST">
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
                                                        <input type="date" name="fecha_inicio" class="form-control" value="{{ $tarifa->fecha_inicio }}" required>
                                                    </div>
                                                    <div class="col-6 mb-3">
                                                        <label class="form-label">Fecha Fin</label>
                                                        <input type="date" name="fecha_fin" class="form-control" value="{{ $tarifa->fecha_fin }}">
                                                    </div>
                                                </div>
                                                <div class="mb-0">
                                                    <label class="form-label">Estado</label>
                                                    <select name="estado" class="form-select">
                                                        <option value="Activa" {{ $tarifa->estado == 'Activa' ? 'selected' : '' }}>Activa</option>
                                                        <option value="Inactiva" {{ $tarifa->estado == 'Inactiva' ? 'selected' : '' }}>Inactiva</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-orange btn-sm">Actualizar Tarifa</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-muted mb-0">No hay tarifas registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Nueva Tarifa -->
    <div class="modal fade" id="nuevaTarifa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.tarifas-destino.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Nueva Tarifa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Destino *</label>
                            <input type="text" name="nombre_destino" class="form-control" placeholder="Ej: San Gil Centro" value="{{ old('nombre_destino') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ciudad *</label>
                            <input type="text" name="ciudad" class="form-control" placeholder="Ej: San Gil" value="{{ old('ciudad') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Departamento *</label>
                            <input type="text" name="departamento" class="form-control" placeholder="Ej: Santander" value="{{ old('departamento') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tarifa Base *</label>
                            <input type="number" name="tarifa_base" class="form-control" placeholder="Ej: 450000" value="{{ old('tarifa_base') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Fecha Inicio *</label>
                                <input type="date" name="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Fecha Fin</label>
                                <input type="date" name="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-orange btn-sm">Crear Tarifa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>