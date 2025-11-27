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
            margin: 0;
            padding: 0;
        }

        /* Header naranja con gradiente */
        .orange-header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            color: white;
            padding: 1.5rem 2rem;
            margin: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .orange-header h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Contenido principal */
        .main-content {
            background: white;
            margin: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Header de sección */
        .section-header {
            background: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h5 {
            margin: 0;
            color: #ff6b35;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Tabla */
        .table-container {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .custom-table thead {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
        }

        .custom-table thead th {
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 1rem;
            border: none;
            letter-spacing: 0.5px;
        }

        .custom-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .custom-table tbody tr {
            transition: background-color 0.2s;
        }

        .custom-table tbody tr:hover {
            background-color: #fff8f6;
        }

        /* Badges para precios */
        .badge-price {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 700;
            background: #d1fae5;
            color: #065f46;
        }

        /* Badges de estado */
        .badge-status {
            display: inline-block;
            padding: 0.4rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-activa {
            background: #d4edda;
            color: #155724;
        }

        .badge-inactiva {
            background: #e2e3e5;
            color: #6c757d;
        }

        /* Botones */
        .btn-custom {
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
        }

        .btn-add {
            background: #ff6b35;
            color: white;
        }

        .btn-add:hover {
            background: #e55a28;
        }

        /* Botones de acción en tabla */
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
            cursor: pointer;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: #ff6b35;
            color: white;
            border-color: #ff6b35;
        }

        /* Modales */
        .modal-content {
            border: none;
            border-radius: 8px;
        }

        .modal-header {
            background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%);
            color: white;
            border-bottom: none;
            padding: 1.25rem 1.5rem;
            border-radius: 8px 8px 0 0;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        /* Formularios */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 0.625rem 0.875rem;
            font-size: 0.9375rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.15);
        }

        /* Detalles en modal */
        .detail-row {
            margin-bottom: 1.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 1rem;
            color: #212529;
            font-weight: 500;
        }

        /* Alertas */
        .alert {
            margin: 1.5rem 2rem;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Header naranja -->
    <div class="orange-header">
        <h4><i class="fas fa-map-marker-alt"></i> Tarifas de Destino - Taxi Express</h4>
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

    <!-- Contenido principal -->
    <div class="main-content">
        <!-- Header de sección -->
        <div class="section-header">
            <h5><i class="fas fa-list"></i> Lista de Tarifas de Destino</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn-custom btn-back">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
                <button class="btn-custom btn-add" data-bs-toggle="modal" data-bs-target="#nuevaTarifa">
                    <i class="fas fa-plus"></i> Nueva Tarifa
                </button>
            </div>
        </div>

        <!-- Tabla -->
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>DESTINO</th>
                        <th>CIUDAD</th>
                        <th>DEPARTAMENTO</th>
                        <th style="text-align: center;">TARIFA</th>
                        <th>VIGENCIA</th>
                        <th style="text-align: center;">ESTADO</th>
                        <th style="text-align: center;">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tarifas as $tarifa)
                        <tr>
                            <td><strong>{{ $tarifa->nombre_destino }}</strong></td>
                            <td>{{ $tarifa->ciudad }}</td>
                            <td>{{ $tarifa->departamento }}</td>
                            <td style="text-align: center;">
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
                            <td style="text-align: center;">
                                <span class="badge-status {{ $tarifa->estado == 'Activa' ? 'badge-activa' : 'badge-inactiva' }}">
                                    {{ $tarifa->estado }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <button class="action-btn" data-bs-toggle="modal" data-bs-target="#ver{{ $tarifa->id_tarifa }}" title="Ver detalles">
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
                                            <span class="badge-status {{ $tarifa->estado == 'Activa' ? 'badge-activa' : 'badge-inactiva' }}">
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
                                                <span class="badge-price" style="font-size: 1.5rem; padding: 0.75rem 1.5rem;">${{ number_format($tarifa->tarifa_base, 0) }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="detail-row">
                                                    <div class="detail-label">Fecha Inicio</div>
                                                    <div class="detail-value">{{ \Carbon\Carbon::parse($tarifa->fecha_inicio)->format('d/m/Y') }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="detail-row">
                                                    <div class="detail-label">Fecha Fin</div>
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
                                        <button type="button" class="btn-custom btn-back" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn-custom btn-add" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#editar{{ $tarifa->id_tarifa }}">
                                            <i class="fas fa-edit"></i> Editar
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
                                            <button type="button" class="btn-custom btn-back" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn-custom btn-add">
                                                <i class="fas fa-save"></i> Actualizar Tarifa
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No hay tarifas registradas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Nueva Tarifa -->
    <div class="modal fade" id="nuevaTarifa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.tarifas-destino.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Nueva Tarifa de Destino</h5>
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
                        <button type="button" class="btn-custom btn-back" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn-custom btn-add">
                            <i class="fas fa-plus"></i> Crear Tarifa
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