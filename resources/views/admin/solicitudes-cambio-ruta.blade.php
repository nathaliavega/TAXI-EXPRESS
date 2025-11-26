<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Cambio de Ruta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<!-- Header con gradiente -->
<div class="bg-gradient-header text-white py-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0 fs-3 fw-bold">Gestión de Solicitudes de Cambio de Ruta</h1>
        <button onclick="window.history.back()" class="btn btn-light">
            <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
        </button>
    </div>
</div>

<div class="container-fluid px-4 py-4">

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



    <!-- Tabla de Solicitudes -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #2c3e50; color: white;">
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
body {
    background-color: #f5f5f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.bg-gradient-header {
    background: linear-gradient(135deg, #e74c3c 0%, #f39c12 100%);
}

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

.card {
    border-radius: 10px;
}

thead {
    border-radius: 10px 10px 0 0;
}
</style>
</body>
</html>