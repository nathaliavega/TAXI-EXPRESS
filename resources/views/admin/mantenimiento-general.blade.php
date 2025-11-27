@extends('layouts.app')

@section('title', 'Mantenimiento General')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">🔧 Mantenimiento General</h1>
            <p class="text-muted mb-0">Gestiona y programa los mantenimientos de tu flota</p>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoMantenimiento">
                <i class="fas fa-plus"></i> Programar Mantenimiento
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

    <!-- Tabla de Mantenimientos -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-tools me-2"></i>Lista de Mantenimientos
            </h6>
            <span class="badge bg-primary">{{ $mantenimientos->total() ?? 0 }} registros</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">Vehículo</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Fecha Programada</th>
                            <th class="text-center">Prioridad</th>
                            <th class="text-center">Estado</th>
                            <th class="text-end">Costo Est.</th>
                            <th class="text-center" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mantenimientos as $mantenimiento)
                            <tr>
                                <td class="px-4">
                                    <div>
                                        <strong class="d-block">{{ $mantenimiento->vehiculo->placa ?? 'N/A' }}</strong>
                                        <small class="text-muted">
                                            <i class="fas fa-truck me-1"></i>{{ $mantenimiento->vehiculo->marca ?? '' }} {{ $mantenimiento->vehiculo->modelo ?? '' }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    @if($mantenimiento->tipo == 'preventivo')
                                        <span class="badge bg-info-subtle text-info px-3 py-2">
                                            <i class="fas fa-tools me-1"></i>Preventivo
                                        </span>
                                    @elseif($mantenimiento->tipo == 'correctivo')
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>Correctivo
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                            <i class="fas fa-chart-line me-1"></i>Predictivo
                                        </span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($mantenimiento->descripcion, 40) }}</td>
                                <td>
                                    <small>
                                        <i class="fas fa-calendar me-1 text-primary"></i>
                                        {{ \Carbon\Carbon::parse($mantenimiento->fecha_programada)->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    @if($mantenimiento->prioridad == 'alta')
                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                            <i class="fas fa-exclamation-circle me-1"></i>Alta
                                        </span>
                                    @elseif($mantenimiento->prioridad == 'media')
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Media
                                        </span>
                                    @else
                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                            <i class="fas fa-check me-1"></i>Baja
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($mantenimiento->estado == 'programado')
                                        <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>Programado
                                        </span>
                                    @elseif($mantenimiento->estado == 'proceso')
                                        <span class="badge bg-info-subtle text-info px-3 py-2">
                                            <i class="fas fa-wrench me-1"></i>En Proceso
                                        </span>
                                    @elseif($mantenimiento->estado == 'completado')
                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Completado
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                            <i class="fas fa-times me-1"></i>Cancelado
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">${{ number_format($mantenimiento->costo_estimado ?? 0, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick='verMantenimiento(@json($mantenimiento))' title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick='editarMantenimiento(@json($mantenimiento))' title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($mantenimiento->estado == 'programado')
                                            <button type="button" class="btn btn-sm btn-outline-success" onclick="iniciarMantenimiento({{ $mantenimiento->id }})" title="Iniciar">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        @elseif($mantenimiento->estado == 'proceso')
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="completarMantenimiento({{ $mantenimiento->id }})" title="Completar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fas fa-tools fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay mantenimientos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        @if($mantenimientos->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-center">
                    {{ $mantenimientos->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Nuevo Mantenimiento -->
<div class="modal fade" id="modalNuevoMantenimiento" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.mantenimiento-general.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Programar Mantenimiento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Vehículo <span class="text-danger">*</span></label>
                            <select name="id_vehiculo" class="form-select" required>
                                <option value="">Seleccionar vehículo...</option>
                                @foreach($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id_vehiculo }}">
                                        {{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tipo de Mantenimiento <span class="text-danger">*</span></label>
                            <select name="tipo" class="form-select" required>
                                <option value="">Seleccionar tipo...</option>
                                <option value="preventivo">Preventivo</option>
                                <option value="correctivo">Correctivo</option>
                                <option value="predictivo">Predictivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Fecha Programada <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_programada" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Prioridad <span class="text-danger">*</span></label>
                            <select name="prioridad" class="form-select" required>
                                <option value="">Seleccionar...</option>
                                <option value="alta">Alta</option>
                                <option value="media">Media</option>
                                <option value="baja">Baja</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Detalle del mantenimiento a realizar" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kilometraje Actual</label>
                            <input type="number" name="kilometraje" class="form-control" placeholder="Ej: 45000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Costo Estimado</label>
                            <input type="number" name="costo_estimado" class="form-control" placeholder="Ej: 250000">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Taller/Proveedor</label>
                        <input type="text" name="taller" class="form-control" placeholder="Nombre del taller">
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="2" placeholder="Observaciones adicionales"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Programar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Tabla */
.table > thead {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
.table > thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
    padding: 1rem 0.75rem;
}
.table > tbody > tr {
    transition: background-color 0.15s ease;
}
.table > tbody > tr:hover {
    background-color: #f8f9fc;
}
.table > tbody > tr > td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

/* Badges mejorados */
.bg-success-subtle {
    background-color: #d1e7dd !important;
}
.bg-secondary-subtle {
    background-color: #e2e3e5 !important;
}
.bg-info-subtle {
    background-color: #cff4fc !important;
}
.bg-warning-subtle {
    background-color: #fff3cd !important;
}
.bg-danger-subtle {
    background-color: #f8d7da !important;
}

/* Botones de acción */
.btn-group .btn {
    padding: 0.4rem 0.6rem;
    border-radius: 5px !important;
    margin: 0 2px;
}

/* Formularios */
.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

/* Cards */
.card {
    border: none;
    border-radius: 10px;
}
.card-header {
    border-bottom: 1px solid #eee;
    border-radius: 10px 10px 0 0 !important;
}
.card-footer {
    border-top: 1px solid #eee;
}
</style>

<script>
function verMantenimiento(mantenimiento) {
    // Implementar modal de visualización
    console.log('Ver:', mantenimiento);
}

function editarMantenimiento(mantenimiento) {
    // Implementar modal de edición
    console.log('Editar:', mantenimiento);
}

function iniciarMantenimiento(id) {
    if(confirm('¿Iniciar este mantenimiento?')) {
        // Llamada AJAX para cambiar estado
        console.log('Iniciar:', id);
    }
}

function completarMantenimiento(id) {
    if(confirm('¿Marcar como completado?')) {
        // Llamada AJAX para cambiar estado
        console.log('Completar:', id);
    }
}
</script>
@endsection