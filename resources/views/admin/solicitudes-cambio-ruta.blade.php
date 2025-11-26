<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Cambio de Ruta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">🚕 Solicitudes de Cambio de Ruta</h2>
            <p class="text-muted mb-0">Gestiona las solicitudes de cambio de ruta de los conductores</p>
        </div>
        <button onclick="window.history.back()" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </button>
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
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-list-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Solicitudes</h6>
                            <h3 class="mb-0">{{ $solicitudes->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Pendientes</h6>
                            <h3 class="mb-0">{{ $solicitudes->where('autorizado_por', null)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-3 p-3">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Procesadas</h6>
                            <h3 class="mb-0">{{ $solicitudes->where('autorizado_por', '!=', null)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Solicitudes -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Fecha</th>
                            <th class="py-3">Conductor</th>
                            <th class="py-3">Vehículo</th>
                            <th class="py-3">Destino</th>
                            <th class="py-3">Contratante</th>
                            <th class="py-3 text-center">Estado</th>
                            <th class="py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($solicitudes as $solicitud)
                            <tr>
                                <td class="px-4">
                                    <div class="small text-muted">
                                        {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}
                                    </div>
                                    <div class="small">
                                        {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('h:i A') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $solicitud->conductor->primer_nombre }} {{ $solicitud->conductor->primer_apellido }}
                                    </div>
                                    <div class="small text-muted">
                                        CC {{ $solicitud->conductor->numero_documento }}
                                    </div>
                                </td>
                                <td>
                                    <div class="badge bg-danger bg-opacity-10 text-danger">
                                        {{ $solicitud->vehiculo->numero_interno }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $solicitud->vehiculo->placa }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $solicitud->tarifaDestino->nombre_destino }}</div>
                                    <div class="small text-muted">{{ $solicitud->tarifaDestino->ciudad }}</div>
                                </td>
                                <td>
                                    <div>{{ $solicitud->nombre_contratante }}</div>
                                    <div class="small text-muted">{{ $solicitud->telefono_contratante }}</div>
                                </td>
                                <td class="text-center">
                                    @if($solicitud->autorizado_por)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Aprobada
                                        </span>
                                        <div class="small text-muted mt-1">
                                            {{ $solicitud->autorizadoPor->nombre ?? 'Admin' }}
                                        </div>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Pendiente
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(!$solicitud->autorizado_por)
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-success" 
                                                    onclick="aprobarSolicitud({{ $solicitud->id_solicitud }})">
                                                <i class="fas fa-check me-1"></i>Aprobar
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="rechazarSolicitud({{ $solicitud->id_solicitud }})">
                                                <i class="fas fa-times me-1"></i>Rechazar
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-muted small">
                                            <i class="fas fa-check-circle"></i> Procesada
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay solicitudes registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($solicitudes->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $solicitudes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Formularios ocultos para aprobar/rechazar -->
<form id="form-aprobar" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<form id="form-rechazar" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function aprobarSolicitud(id) {
    if (confirm('¿Está seguro de aprobar esta solicitud de cambio de ruta?')) {
        const form = document.getElementById('form-aprobar');
        form.action = `/admin/solicitudes/aprobar/${id}`;
        form.submit();
    }
}

function rechazarSolicitud(id) {
    if (confirm('¿Está seguro de rechazar esta solicitud de cambio de ruta?')) {
        const form = document.getElementById('form-rechazar');
        form.action = `/admin/solicitudes/rechazar/${id}`;
        form.submit();
    }
}
</script>

<style>
.table > tbody > tr:hover {
    background-color: #f8f9fa;
}

.btn-group .btn {
    padding: 0.25rem 0.75rem;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}
</style>
</body>
</html>