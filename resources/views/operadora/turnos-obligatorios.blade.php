<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnos Obligatorios - Operadora</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .navbar {
            background: linear-gradient(135deg, #9c27b0, #e91e63);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            font-size: 24px;
        }
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-logout {
            background: white;
            color: #9c27b0;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background: #9c27b0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background: #7b1fa2;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-nuevo {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-nuevo:hover {
            background: #45a049;
        }
        .turnos-table {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #9c27b0;
            color: white;
            font-weight: bold;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge.programado {
            background: #2196F3;
            color: white;
        }
        .badge.cumplido {
            background: #4CAF50;
            color: white;
        }
        .badge.incumplido {
            background: #f44336;
            color: white;
        }
        .badge.justificado {
            background: #FF9800;
            color: white;
        }
        .badge.cancelado {
            background: #9E9E9E;
            color: white;
        }
        .actions {
            display: flex;
            gap: 8px;
        }
        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .btn-edit {
            background: #2196F3;
            color: white;
        }
        .btn-edit:hover {
            background: #1976D2;
        }
        .btn-delete {
            background: #f44336;
            color: white;
        }
        .btn-delete:hover {
            background: #d32f2f;
        }
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }
        .pagination .active {
            background: #9c27b0;
            color: white;
            border-color: #9c27b0;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            position: relative;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-close {
            position: absolute;
            right: 15px;
            top: 15px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: inherit;
        }

        /* MODAL STYLES */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow-y: auto;
        }
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .modal-header {
            background: linear-gradient(135deg, #9c27b0, #e91e63);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h2 {
            margin: 0;
            font-size: 22px;
        }
        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
            line-height: 1;
        }
        .modal-close:hover {
            opacity: 0.8;
        }
        .modal-body {
            padding: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #9c27b0;
        }
        .error-message {
            color: #f44336;
            font-size: 13px;
            margin-top: 5px;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
        .btn-submit {
            flex: 1;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
        .btn-submit:hover {
            background: #45a049;
        }
        .btn-cancel {
            flex: 1;
            padding: 12px;
            background: #9E9E9E;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }
        .btn-cancel:hover {
            background: #757575;
        }
        .info-box {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2196F3;
        }
        .info-box p {
            margin: 5px 0;
            color: #1976D2;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Turnos Obligatorios - Taxi Express Pamplona</h1>
        <div class="user-info">
            <span>Bienvenida, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <div class="container">
        <a href="{{ route('operadora.dashboard') }}" class="btn-back">← Volver al Dashboard</a>

        @if(session('success'))
            <div class="alert alert-success" id="alert-success">
                {{ session('success') }}
                <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error" id="alert-error">
                {{ session('error') }}
                <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Errores en el formulario:</strong>
                <ul style="margin-top: 10px; margin-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
            <script>
                // Abrir modal si hay errores
                @if (old('_method') === 'PUT')
                    setTimeout(() => openCreateModal(), 100);
                @else
                    setTimeout(() => openCreateModal(), 100);
                @endif
            </script>
        @endif

        <div class="header-actions">
            <h2>Turnos Obligatorios Programados</h2>
            <button class="btn-nuevo" onclick="openCreateModal()">+ Nuevo Turno</button>
        </div>

        <div class="turnos-table">
            @if($turnos->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Vehículo</th>
                            <th>Conductor</th>
                            <th>Estado</th>
                            <th>Asignado Por</th>
                            <th>Fecha Asignación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($turnos as $turno)
                            <tr>
                                <td>{{ $turno->fecha_turno->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $turno->vehiculo->placa ?? 'N/A' }}</strong><br>
                                    <small>Móvil {{ $turno->vehiculo->numero_interno ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    {{ $turno->conductor->primer_nombre ?? 'N/A' }} 
                                    {{ $turno->conductor->primer_apellido ?? '' }}
                                </td>
                                <td>
                                    <span class="badge {{ $turno->estado }}">
                                        {{ ucfirst($turno->estado) }}
                                    </span>
                                </td>
                                <td>{{ $turno->asignadoPor->nombre ?? 'Sistema' }}</td>
                                <td>{{ $turno->fecha_asignacion ? $turno->fecha_asignacion->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>
                                    <div class="actions">
                                        <button class="btn-action btn-edit" onclick='openEditModal(@json($turno))'>Editar</button>
                                        <form action="{{ route('operadora.turnos-obligatorios.destroy', $turno->id_turno) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('¿Estás segura de eliminar este turno?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $turnos->links() }}
                </div>
            @else
                <p style="text-align: center; padding: 40px;">No hay turnos obligatorios programados.</p>
            @endif
        </div>
    </div>

    <!-- MODAL CREAR -->
    <div id="modalCrear" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Nuevo Turno Obligatorio</h2>
                <button class="modal-close" onclick="closeCreateModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('operadora.turnos-obligatorios.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="id_vehiculo">Vehículo *</label>
                        <select name="id_vehiculo" id="id_vehiculo" required>
                            <option value="">Seleccione un vehículo</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}" {{ old('id_vehiculo') == $vehiculo->id_vehiculo ? 'selected' : '' }}>
                                    {{ $vehiculo->placa }} - Móvil {{ $vehiculo->numero_interno }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_conductor">Conductor *</label>
                        <select name="id_conductor" id="id_conductor" required>
                            <option value="">Seleccione un conductor</option>
                            @foreach($conductores as $conductor)
                                <option value="{{ $conductor->id_conductor }}" {{ old('id_conductor') == $conductor->id_conductor ? 'selected' : '' }}>
                                    {{ $conductor->primer_nombre }} {{ $conductor->primer_apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_turno">Fecha del Turno *</label>
                        <input type="date" name="fecha_turno" id="fecha_turno" value="{{ old('fecha_turno') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado *</label>
                        <select name="estado" id="estado" required>
                            <option value="programado" {{ old('estado', 'programado') == 'programado' ? 'selected' : '' }}>Programado</option>
                            <option value="cumplido" {{ old('estado') == 'cumplido' ? 'selected' : '' }}>Cumplido</option>
                            <option value="incumplido" {{ old('estado') == 'incumplido' ? 'selected' : '' }}>Incumplido</option>
                            <option value="justificado" {{ old('estado') == 'justificado' ? 'selected' : '' }}>Justificado</option>
                            <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closeCreateModal()">Cancelar</button>
                        <button type="submit" class="btn-submit">Crear Turno</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDITAR -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Turno Obligatorio</h2>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="info-box" id="infoBox" style="display: none;">
                    <p><strong>Asignado por:</strong> <span id="infoAsignado"></span></p>
                    <p><strong>Fecha de asignación:</strong> <span id="infoFecha"></span></p>
                </div>

                <form id="formEditar" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="edit_id_vehiculo">Vehículo *</label>
                        <select name="id_vehiculo" id="edit_id_vehiculo" required>
                            <option value="">Seleccione un vehículo</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id_vehiculo }}">
                                    {{ $vehiculo->placa }} - Móvil {{ $vehiculo->numero_interno }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_id_conductor">Conductor *</label>
                        <select name="id_conductor" id="edit_id_conductor" required>
                            <option value="">Seleccione un conductor</option>
                            @foreach($conductores as $conductor)
                                <option value="{{ $conductor->id_conductor }}">
                                    {{ $conductor->primer_nombre }} {{ $conductor->primer_apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_fecha_turno">Fecha del Turno *</label>
                        <input type="date" name="fecha_turno" id="edit_fecha_turno" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_estado">Estado *</label>
                        <select name="estado" id="edit_estado" required>
                            <option value="programado">Programado</option>
                            <option value="cumplido">Cumplido</option>
                            <option value="incumplido">Incumplido</option>
                            <option value="justificado">Justificado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancelar</button>
                        <button type="submit" class="btn-submit" style="background: #2196F3;">Actualizar Turno</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
       
        function openCreateModal() {
            document.getElementById('modalCrear').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('modalCrear').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function openEditModal(turno) {
            const modal = document.getElementById('modalEditar');
            const form = document.getElementById('formEditar');
   
            form.action = `/operadora/turnos-obligatorios/${turno.id_turno}`;
            
            document.getElementById('edit_id_vehiculo').value = turno.id_vehiculo;
            document.getElementById('edit_id_conductor').value = turno.id_conductor;
            
            let fechaTurno = turno.fecha_turno;
            if (typeof fechaTurno === 'object' && fechaTurno.date) {
                fechaTurno = fechaTurno.date.split(' ')[0];
            } else if (typeof fechaTurno === 'string') {
                fechaTurno = fechaTurno.split('T')[0].split(' ')[0];
            }
            document.getElementById('edit_fecha_turno').value = fechaTurno;
            document.getElementById('edit_estado').value = turno.estado;
            
            if (turno.asignado_por) {
                document.getElementById('infoBox').style.display = 'block';
                const nombreAsignado = turno.asignado_por_nombre || turno.asignado_por?.nombre || 'Sistema';
                document.getElementById('infoAsignado').textContent = nombreAsignado;
                
                let fechaAsignacion = turno.fecha_asignacion;
                if (typeof fechaAsignacion === 'object' && fechaAsignacion.date) {
                    fechaAsignacion = fechaAsignacion.date;
                }
                document.getElementById('infoFecha').textContent = new Date(fechaAsignacion).toLocaleString('es-CO');
            }
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('modalEditar').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modalCrear = document.getElementById('modalCrear');
            const modalEditar = document.getElementById('modalEditar');
            
            if (event.target === modalCrear) {
                closeCreateModal();
            }
            if (event.target === modalEditar) {
                closeEditModal();
            }
        }

        // Auto-cerrar alertas después de 5 segundos
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Si hay errores, abrir el modal correspondiente
        @if ($errors->any())
            @if (old('_method') === 'PUT')
                // Intentar recuperar datos del formulario de edición
                setTimeout(() => {
                    const oldData = {
                        id_turno: '{{ old('id_turno') }}',
                        id_vehiculo: '{{ old('id_vehiculo') }}',
                        id_conductor: '{{ old('id_conductor') }}',
                        fecha_turno: '{{ old('fecha_turno') }}',
                        estado: '{{ old('estado') }}'
                    };
                    if (oldData.id_turno) {
                        openEditModal(oldData);
                    }
                }, 100);
            @else
                openCreateModal();
            @endif
        @endif
    </script>
</body>
</html>