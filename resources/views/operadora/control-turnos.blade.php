<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Turnos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        }
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .back-link {
            display: inline-block;
            padding: 10px 20px;
            background: #9c27b0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .back-link:hover {
            background: #7b1fa2;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #9c27b0;
            color: white;
            font-size: 14px;
        }
        tr.editing {
            background: #fff3e0;
        }
        tr:hover:not(.editing) {
            background: #f5f5f5;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
        .badge.si {
            background: #d4edda;
            color: #155724;
        }
        .badge.no {
            background: #f8d7da;
            color: #721c24;
        }
        .edit-input, .edit-select {
            width: 100%;
            padding: 6px;
            border: 2px solid #9c27b0;
            border-radius: 4px;
            font-size: 13px;
        }
        .edit-input:focus, .edit-select:focus {
            outline: none;
            border-color: #e91e63;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            margin: 2px;
            transition: all 0.3s;
        }
        .btn-edit {
            background: #2196F3;
            color: white;
        }
        .btn-edit:hover {
            background: #1976D2;
        }
        .btn-save {
            background: #4CAF50;
            color: white;
        }
        .btn-save:hover {
            background: #45a049;
        }
        .btn-cancel {
            background: #f44336;
            color: white;
        }
        .btn-cancel:hover {
            background: #da190b;
        }
        .btn-delete {
            background: #ff5722;
            color: white;
        }
        .btn-delete:hover {
            background: #e64a19;
        }
        .actions-cell {
            white-space: nowrap;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #4CAF50;
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert.show {
            display: block;
        }
        .loading {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Control de Turnos</h1>
    </div>

    <div class="container">
        <a href="{{ route('operadora.dashboard') }}" class="back-link">← Volver al Dashboard</a>

        <div id="alert" class="alert"></div>

        <table id="turnosTable">
            <thead>
                <tr>
                    <th>Vehículo</th>
                    <th>Conductor</th>
                    <th>Franja</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Hora Llamado</th>
                    <th>Respondió</th>
                    <th>En Servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($controles as $control)
                    <tr id="row-{{ $control->id_control }}" data-id="{{ $control->id_control }}">
                        <td class="vehiculo-cell" data-vehiculo-id="{{ $control->turno->vehiculo->id_vehiculo }}">
                            {{ $control->turno->vehiculo->placa }}
                        </td>
                        <td class="conductor-cell" data-conductor-id="{{ $control->turno->conductor->id_conductor }}">
                            {{ $control->turno->conductor->primer_nombre }} {{ $control->turno->conductor->primer_apellido }}
                        </td>
                        <td class="franja-cell" data-franja="{{ $control->nombre_franja }}">
                            {{ $control->nombre_franja }}
                        </td>
                        <td class="hora-inicio-cell">{{ $control->hora_inicio }}</td>
                        <td class="hora-fin-cell">{{ $control->hora_fin }}</td>
                        <td class="hora-llamado-cell">{{ $control->hora_llamado }}</td>
                        <td class="respondio-cell">
                            <span class="badge {{ $control->respondio ? 'si' : 'no' }}">
                                {{ $control->respondio ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="servicio-cell">
                            <span class="badge {{ $control->en_servicio ? 'si' : 'no' }}">
                                {{ $control->en_servicio ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="actions-cell">
                            <button class="btn btn-edit" onclick="editRow({{ $control->id_control }})">Editar</button>
                            <button class="btn btn-delete" onclick="deleteRow({{ $control->id_control }})">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center;">No hay controles de turno registrados hoy</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        // Datos necesarios para los selects
        const vehiculos = @json($vehiculos ?? []);
        const conductores = @json($conductores ?? []);
        const franjas = ['Turno_noche', 'Turno_mañana'];

        let editingRow = null;
        let originalData = {};

        // Configurar CSRF token para todas las peticiones AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function showAlert(message, type) {
            const alert = document.getElementById('alert');
            alert.textContent = message;
            alert.className = `alert ${type} show`;
            setTimeout(() => {
                alert.classList.remove('show');
            }, 3000);
        }

        // Función auxiliar para convertir hora a formato HH:MM
        function formatTime(time) {
            if (!time) return '';
            // Si viene en formato HH:MM:SS, extraer solo HH:MM
            const parts = time.trim().split(':');
            if (parts.length >= 2) {
                return `${parts[0].padStart(2, '0')}:${parts[1].padStart(2, '0')}`;
            }
            return time.trim();
        }

        function editRow(id) {
            if (editingRow) {
                showAlert('Ya hay una fila en edición. Guarda o cancela primero.', 'error');
                return;
            }

            editingRow = id;
            const row = document.getElementById(`row-${id}`);
            row.classList.add('editing');

            // Guardar datos originales
            originalData = {
                vehiculoId: row.querySelector('.vehiculo-cell').dataset.vehiculoId,
                conductorId: row.querySelector('.conductor-cell').dataset.conductorId,
                franja: row.querySelector('.franja-cell').dataset.franja,
                horaInicio: formatTime(row.querySelector('.hora-inicio-cell').textContent),
                horaFin: formatTime(row.querySelector('.hora-fin-cell').textContent),
                horaLlamado: formatTime(row.querySelector('.hora-llamado-cell').textContent),
                respondio: row.querySelector('.respondio-cell .badge').classList.contains('si'),
                enServicio: row.querySelector('.servicio-cell .badge').classList.contains('si')
            };

            console.log('Datos originales capturados:', originalData);

            // Convertir celdas a inputs/selects
            row.querySelector('.vehiculo-cell').innerHTML = createSelectVehiculos(originalData.vehiculoId);
            row.querySelector('.conductor-cell').innerHTML = createSelectConductores(originalData.conductorId);
            row.querySelector('.franja-cell').innerHTML = createSelectFranja(originalData.franja);
            row.querySelector('.hora-inicio-cell').innerHTML = `<input type="time" class="edit-input" value="${originalData.horaInicio}" step="60">`;
            row.querySelector('.hora-fin-cell').innerHTML = `<input type="time" class="edit-input" value="${originalData.horaFin}" step="60">`;
            row.querySelector('.hora-llamado-cell').innerHTML = `<input type="time" class="edit-input" value="${originalData.horaLlamado}" step="60">`;
            row.querySelector('.respondio-cell').innerHTML = createToggle('respondio', originalData.respondio);
            row.querySelector('.servicio-cell').innerHTML = createToggle('servicio', originalData.enServicio);

            // Cambiar botones
            row.querySelector('.actions-cell').innerHTML = `
                <button class="btn btn-save" onclick="saveRow(${id})">Guardar</button>
                <button class="btn btn-cancel" onclick="cancelEdit(${id})">Cancelar</button>
            `;
        }

        function createSelectVehiculos(selectedId) {
            let html = '<select class="edit-select">';
            vehiculos.forEach(v => {
                html += `<option value="${v.id}" ${v.id == selectedId ? 'selected' : ''}>${v.placa}</option>`;
            });
            html += '</select>';
            return html;
        }

        function createSelectConductores(selectedId) {
            let html = '<select class="edit-select">';
            conductores.forEach(c => {
                html += `<option value="${c.id}" ${c.id == selectedId ? 'selected' : ''}>${c.primer_nombre} ${c.primer_apellido}</option>`;
            });
            html += '</select>';
            return html;
        }

        function createSelectFranja(selected) {
            let html = '<select class="edit-select">';
            franjas.forEach(f => {
                html += `<option value="${f}" ${f === selected ? 'selected' : ''}>${f}</option>`;
            });
            html += '</select>';
            return html;
        }

        function createToggle(name, checked) {
            return `
                <label class="toggle-switch">
                    <input type="checkbox" ${checked ? 'checked' : ''}>
                    <span class="slider"></span>
                </label>
            `;
        }

        async function saveRow(id) {
            const row = document.getElementById(`row-${id}`);
            
            // Recoger datos del formulario
            const data = {
                vehiculo_id: parseInt(row.querySelector('.vehiculo-cell select').value),
                conductor_id: parseInt(row.querySelector('.conductor-cell select').value),
                nombre_franja: row.querySelector('.franja-cell select').value,
                hora_inicio: row.querySelector('.hora-inicio-cell input').value,
                hora_fin: row.querySelector('.hora-fin-cell input').value,
                hora_llamado: row.querySelector('.hora-llamado-cell input').value,
                respondio: row.querySelector('.respondio-cell input[type="checkbox"]').checked ? 1 : 0,
                en_servicio: row.querySelector('.servicio-cell input[type="checkbox"]').checked ? 1 : 0
            };

            // Debug: mostrar datos que se van a enviar
            console.log('Datos a enviar:', data);

            // Validar datos
            if (!data.hora_inicio || !data.hora_fin || !data.hora_llamado) {
                showAlert('Todos los horarios son obligatorios', 'error');
                return;
            }

            // Validar formato de hora (HH:MM)
            const timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
            if (!timeRegex.test(data.hora_inicio) || !timeRegex.test(data.hora_fin) || !timeRegex.test(data.hora_llamado)) {
                showAlert('El formato de las horas debe ser HH:MM (24 horas)', 'error');
                return;
            }

            row.classList.add('loading');

            try {
                const response = await fetch(`/operadora/control-turnos/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    showAlert('Turno actualizado exitosamente', 'success');
                    
                    // Actualizar la vista con los datos guardados
                    const vehiculo = vehiculos.find(v => v.id == data.vehiculo_id);
                    const conductor = conductores.find(c => c.id == data.conductor_id);

                    row.querySelector('.vehiculo-cell').innerHTML = vehiculo.placa;
                    row.querySelector('.vehiculo-cell').dataset.vehiculoId = data.vehiculo_id;
                    
                    row.querySelector('.conductor-cell').innerHTML = `${conductor.primer_nombre} ${conductor.primer_apellido}`;
                    row.querySelector('.conductor-cell').dataset.conductorId = data.conductor_id;
                    
                    row.querySelector('.franja-cell').innerHTML = data.nombre_franja;
                    row.querySelector('.franja-cell').dataset.franja = data.nombre_franja;
                    
                    row.querySelector('.hora-inicio-cell').innerHTML = data.hora_inicio;
                    row.querySelector('.hora-fin-cell').innerHTML = data.hora_fin;
                    row.querySelector('.hora-llamado-cell').innerHTML = data.hora_llamado;
                    
                    row.querySelector('.respondio-cell').innerHTML = `<span class="badge ${data.respondio ? 'si' : 'no'}">${data.respondio ? 'Sí' : 'No'}</span>`;
                    row.querySelector('.servicio-cell').innerHTML = `<span class="badge ${data.en_servicio ? 'si' : 'no'}">${data.en_servicio ? 'Sí' : 'No'}</span>`;
                    
                    row.querySelector('.actions-cell').innerHTML = `
                        <button class="btn btn-edit" onclick="editRow(${id})">Editar</button>
                        <button class="btn btn-delete" onclick="deleteRow(${id})">Eliminar</button>
                    `;
                    
                    row.classList.remove('editing');
                    editingRow = null;
                } else {
                    // Mostrar errores específicos de validación si existen
                    if (result.errors) {
                        const errorMessages = Object.values(result.errors).flat().join(', ');
                        showAlert('Errores: ' + errorMessages, 'error');
                    } else {
                        showAlert(result.message || 'Error al actualizar el turno', 'error');
                    }
                    console.error('Respuesta del servidor:', result);
                }
            } catch (error) {
                showAlert('Error de conexión. Inténtalo de nuevo.', 'error');
                console.error('Error:', error);
            } finally {
                row.classList.remove('loading');
            }
        }

        function cancelEdit(id) {
            const row = document.getElementById(`row-${id}`);
            
            // Restaurar datos originales
            const vehiculo = vehiculos.find(v => v.id == originalData.vehiculoId);
            const conductor = conductores.find(c => c.id == originalData.conductorId);

            row.querySelector('.vehiculo-cell').innerHTML = vehiculo.placa;
            row.querySelector('.conductor-cell').innerHTML = `${conductor.primer_nombre} ${conductor.primer_apellido}`;
            row.querySelector('.franja-cell').innerHTML = originalData.franja;
            row.querySelector('.hora-inicio-cell').innerHTML = originalData.horaInicio;
            row.querySelector('.hora-fin-cell').innerHTML = originalData.horaFin;
            row.querySelector('.hora-llamado-cell').innerHTML = originalData.horaLlamado;
            row.querySelector('.respondio-cell').innerHTML = `<span class="badge ${originalData.respondio ? 'si' : 'no'}">${originalData.respondio ? 'Sí' : 'No'}</span>`;
            row.querySelector('.servicio-cell').innerHTML = `<span class="badge ${originalData.enServicio ? 'si' : 'no'}">${originalData.enServicio ? 'Sí' : 'No'}</span>`;
            
            row.querySelector('.actions-cell').innerHTML = `
                <button class="btn btn-edit" onclick="editRow(${id})">Editar</button>
                <button class="btn btn-delete" onclick="deleteRow(${id})">Eliminar</button>
            `;
            
            row.classList.remove('editing');
            editingRow = null;
        }

        async function deleteRow(id) {
            if (!confirm('¿Estás segura de que deseas eliminar este turno?')) {
                return;
            }

            const row = document.getElementById(`row-${id}`);
            row.classList.add('loading');

            try {
                const response = await fetch(`/operadora/control-turnos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showAlert('Turno eliminado exitosamente', 'success');
                    row.remove();
                    
                    // Si no quedan filas, mostrar mensaje
                    const tbody = document.querySelector('#turnosTable tbody');
                    if (tbody.children.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="9" style="text-align: center;">No hay controles de turno registrados hoy</td></tr>';
                    }
                } else {
                    showAlert(result.message || 'Error al eliminar el turno', 'error');
                    row.classList.remove('loading');
                }
            } catch (error) {
                showAlert('Error de conexión. Inténtalo de nuevo.', 'error');
                row.classList.remove('loading');
                console.error('Error:', error);
            }
        }
    </script>
</body>
</html>