@extends('layouts.app')

@section('title', 'Solicitudes de Cambio de Ruta')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('conductor.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Solicitudes de Cambio de Ruta</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-route me-2"></i>Solicitudes de Cambio de Ruta</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaSolicitud">
            <i class="fas fa-plus me-2"></i>Nueva Solicitud
        </button>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Solicitudes</h6>
                            <h3 class="mb-0">67</h3>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Pendientes</h6>
                            <h3 class="mb-0">18</h3>
                        </div>
                        <div class="fs-1 text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Aprobadas</h6>
                            <h3 class="mb-0">42</h3>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Rechazadas</h6>
                            <h3 class="mb-0">7</h3>
                        </div>
                        <div class="fs-1 text-danger">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="revision">En Revisión</option>
                        <option value="aprobada">Aprobada</option>
                        <option value="rechazada">Rechazada</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Conductor</label>
                    <select class="form-select">
                        <option value="">Todos</option>
                        <option value="1">Juan Pérez</option>
                        <option value="2">María López</option>
                        <option value="3">Carlos Martínez</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Buscar</label>
                    <input type="text" class="form-control" placeholder="Buscar...">
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="solicitudesTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="todas-tab" data-bs-toggle="tab" data-bs-target="#todas" type="button">
                Todas <span class="badge bg-primary ms-2">67</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pendientes-tab" data-bs-toggle="tab" data-bs-target="#pendientes" type="button">
                Pendientes <span class="badge bg-warning ms-2">18</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="aprobadas-tab" data-bs-toggle="tab" data-bs-target="#aprobadas" type="button">
                Aprobadas <span class="badge bg-success ms-2">42</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rechazadas-tab" data-bs-toggle="tab" data-bs-target="#rechazadas" type="button">
                Rechazadas <span class="badge bg-danger ms-2">7</span>
            </button>
        </li>
    </ul>

    <!-- Contenido de Tabs -->
    <div class="tab-content" id="solicitudesTabsContent">
        <div class="tab-pane fade show active" id="todas" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha Solicitud</th>
                                    <th>Conductor</th>
                                    <th>Vehículo</th>
                                    <th>Ruta Actual</th>
                                    <th>Ruta Nueva</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>21/11/2024<br><small class="text-muted">10:30 AM</small></td>
                                    <td>
                                        <strong>Juan Pérez</strong><br>
                                        <small class="text-muted">CC 1234567890</small>
                                    </td>
                                    <td>ABC-123</td>
                                    <td>
                                        <strong>Bucaramanga → Cúcuta</strong><br>
                                        <small class="text-muted">Ruta 45</small>
                                    </td>
                                    <td>
                                        <strong>Bucaramanga → Medellín</strong><br>
                                        <small class="text-muted">Ruta 23</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Motivo personal - cercanía familiar">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVerSolicitud">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAprobarSolicitud">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalRechazarSolicitud">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>20/11/2024<br><small class="text-muted">02:15 PM</small></td>
                                    <td>
                                        <strong>María López</strong><br>
                                        <small class="text-muted">CC 9876543210</small>
                                    </td>
                                    <td>XYZ-789</td>
                                    <td>
                                        <strong>Bogotá → Cali</strong><br>
                                        <small class="text-muted">Ruta 12</small>
                                    </td>
                                    <td>
                                        <strong>Bogotá → Cartagena</strong><br>
                                        <small class="text-muted">Ruta 67</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Mejor conocimiento de la ruta">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                    <td><span class="badge bg-success">Aprobada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVerSolicitud">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>19/11/2024<br><small class="text-muted">09:45 AM</small></td>
                                    <td>
                                        <strong>Carlos Martínez</strong><br>
                                        <small class="text-muted">CC 5551234567</small>
                                    </td>
                                    <td>DEF-456</td>
                                    <td>
                                        <strong>Medellín → Barranquilla</strong><br>
                                        <small class="text-muted">Ruta 89</small>
                                    </td>
                                    <td>
                                        <strong>Medellín → Santa Marta</strong><br>
                                        <small class="text-muted">Ruta 34</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Problemas de salud">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                    <td><span class="badge bg-primary">En Revisión</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVerSolicitud">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalAprobarSolicitud">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalRechazarSolicitud">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <nav>
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Anterior</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Solicitud -->
<div class="modal fade" id="modalNuevaSolicitud" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Solicitud de Cambio de Ruta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Conductor</label>
                            <select class="form-select" required>
                                <option value="">Seleccionar conductor...</option>
                                <option value="1">Juan Pérez - CC 1234567890</option>
                                <option value="2">María López - CC 9876543210</option>
                                <option value="3">Carlos Martínez - CC 5551234567</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vehículo</label>
                            <select class="form-select" required>
                                <option value="">Seleccionar vehículo...</option>
                                <option value="1">ABC-123 - Chevrolet NPR</option>
                                <option value="2">XYZ-789 - Ford Cargo</option>
                                <option value="3">DEF-456 - Isuzu NQR</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h6>Ruta Actual</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Origen</label>
                            <input type="text" class="form-control" placeholder="Ciudad de origen" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Destino</label>
                            <input type="text" class="form-control" placeholder="Ciudad de destino" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código Ruta Actual</label>
                        <input type="text" class="form-control" placeholder="Ej: Ruta 45" required>
                    </div>
                    <hr>
                    <h6>Nueva Ruta Solicitada</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nuevo Origen</label>
                            <input type="text" class="form-control" placeholder="Ciudad de origen" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nuevo Destino</label>
                            <input type="text" class="form-control" placeholder="Ciudad de destino" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código Nueva Ruta</label>
                        <input type="text" class="form-control" placeholder="Ej: Ruta 23">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo de la Solicitud</label>
                        <textarea class="form-control" rows="4" placeholder="Explique detalladamente el motivo del cambio de ruta..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Efectiva del Cambio</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Documentos de Soporte (Opcional)</label>
                        <input type="file" class="form-control" accept=".pdf,.jpg,.png" multiple>
                        <small class="text-muted">Puede adjuntar certificados médicos, cartas, etc.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Enviar Solicitud</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Solicitud -->
<div class="modal fade" id="modalVerSolicitud" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <strong>Estado:</strong> <span class="badge bg-warning ms-2">Pendiente de Aprobación</span>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Fecha de Solicitud:</strong>
                        <p>21/11/2024 10:30 AM</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Conductor:</strong>
                        <p>Juan Pérez González - CC 1234567890</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Vehículo:</strong>
                        <p>ABC-123 - Chevrolet NPR 2020</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha Efectiva:</strong>
                        <p>25/11/2024</p>
                    </div>
                </div>
                <hr>
                <h6>Ruta Actual</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Origen:</strong>
                        <p>Bucaramanga</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Destino:</strong>
                        <p>Cúcuta</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Código:</strong>
                        <p>Ruta 45</p>
                    </div>
                </div>
                <hr>
                <h6>Nueva Ruta Solicitada</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Origen:</strong>
                        <p>Bucaramanga</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Destino:</strong>
                        <p>Medellín</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Código:</strong>
                        <p>Ruta 23</p>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <strong>Motivo de la Solicitud:</strong>
                    <p>Por motivos personales, requiero cambiar mi ruta habitual. Tengo familia en Medellín que necesita mi apoyo y este cambio me permitiría estar más cerca de ellos. Conozco bien la ruta Bucaramanga-Medellín y cuento con la experiencia necesaria para operarla de manera segura y eficiente.</p>
                </div>
                <div class="mb-3">
                    <strong>Documentos Adjuntos:</strong>
                    <div class="mt-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary me-2">
                            <i class="fas fa-file-pdf me-1"></i>Carta_Justificacion.pdf
                        </a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Solicitado por:</strong>
                        <p>Juan Pérez González</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Revisado por:</strong>
                        <p><span class="text-muted">Pendiente</span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAprobarSolicitud">
                    <i class="fas fa-check me-2"></i>Aprobar
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRechazarSolicitud">
                    <i class="fas fa-times me-2"></i>Rechazar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Aprobar Solicitud -->
<div class="modal fade" id="modalAprobarSolicitud" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Aprobar Solicitud</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de aprobar esta solicitud de cambio de ruta?</p>
                <div class="mb-3">
                    <label class="form-label">Observaciones (Opcional)</label>
                    <textarea class="form-control" rows="3" placeholder="Agregue observaciones sobre la aprobación..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success">Confirmar Aprobación</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rechazar Solicitud -->
<div class="modal fade" id="modalRechazarSolicitud" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Rechazar Solicitud</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de rechazar esta solicitud de cambio de ruta?</p>
                <div class="mb-3">
                    <label class="form-label">Motivo del Rechazo <span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="3" placeholder="Explique el motivo del rechazo..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger">Confirmar Rechazo</button>
            </div>
        </div>
    </div>
</div>
@endsection