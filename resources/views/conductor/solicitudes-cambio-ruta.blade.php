<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Cambio de Ruta - TAXI EXPRESS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);
            min-height: 100vh;
            padding: 0;
        }

        .header {
            background: linear-gradient(135deg, #00bcd4 0%, #00acc1 100%);
            color: white;
            padding: 25px 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            font-size: 32px;
        }

        .header-title {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn-volver {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #00bcd4;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 20px 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-volver:hover {
            background: #0097a7;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-volver svg {
            width: 20px;
            height: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px 40px;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .form-header {
            background: linear-gradient(135deg, #00bcd4 0%, #00acc1 100%);
            color: white;
            padding: 25px 30px;
        }

        .form-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .form-content {
            padding: 30px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #e0e0e0;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #00bcd4;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 24px;
            height: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .required {
            color: #f44336;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #00bcd4;
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-input.error,
        .form-select.error,
        .form-textarea.error {
            border-color: #f44336;
        }

        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-box p {
            margin: 5px 0;
            color: #1565c0;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-cancelar {
            background: #e0e0e0;
            color: #666;
        }

        .btn-cancelar:hover {
            background: #d0d0d0;
        }

        .btn-enviar {
            background: linear-gradient(135deg, #00bcd4 0%, #00acc1 100%);
            color: white;
            box-shadow: 0 4px 8px rgba(0, 188, 212, 0.3);
        }

        .btn-enviar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 188, 212, 0.4);
        }

        .btn svg {
            width: 20px;
            height: 20px;
        }

        .alert {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease;
            z-index: 1000;
            max-width: 400px;
        }

        .alert-success {
            background: #4caf50;
        }

        .alert-error {
            background: #f44336;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Tabla de solicitudes */
        .solicitudes-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .solicitudes-table thead {
            background: #f5f5f5;
        }

        .solicitudes-table th,
        .solicitudes-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .solicitudes-table th {
            font-weight: 600;
            color: #333;
        }

        .estado-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .estado-aprobada {
            background: #d4edda;
            color: #155724;
        }

        .estado-rechazada {
            background: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .header {
                padding: 20px 20px;
            }

            .header-title {
                font-size: 22px;
            }

            .container {
                padding: 0 20px 20px;
            }

            .form-content {
                padding: 20px;
            }

            .btn-volver {
                margin: 15px 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .alert {
                max-width: 90%;
                left: 5%;
                right: 5%;
            }

            .solicitudes-table {
                font-size: 14px;
            }

            .solicitudes-table th,
            .solicitudes-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <span class="header-icon">🔄</span>
            <h1 class="header-title">Solicitudes de Cambio de Ruta</h1>
        </div>
    </div>

    <a href="{{ route('conductor.dashboard') }}" class="btn-volver">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver al Dashboard
    </a>

    <div class="container">
        <!-- Formulario para Nueva Solicitud -->
        <div class="form-card">
            <div class="form-header">
                <h2>Nueva Solicitud de Cambio de Ruta</h2>
                <p>Solicita cambiar tu ruta asignada actual por una nueva</p>
            </div>

            <form action="{{ route('conductor.solicitudes-cambio-ruta.store') }}" method="POST" class="form-content" id="solicitudForm">
                @csrf
                
                <!-- Información Actual -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tu Información Actual
                    </h3>

                    <div class="info-box">
                        <p><strong>Conductor:</strong> {{ $conductor->primer_nombre }} {{ $conductor->primer_apellido }}</p>
                        <p><strong>Vehículo:</strong> {{ $conductor->vehiculo->placa ?? 'No asignado' }}</p>
                        @if($conductor->vehiculo && $conductor->vehiculo->tarifaDestino)
                            <p><strong>Ruta Actual:</strong> {{ $conductor->vehiculo->tarifaDestino->nombre_destino }}</p>
                        @else
                            <p><strong>Ruta Actual:</strong> Sin ruta asignada</p>
                        @endif
                    </div>
                </div>

                <!-- Selección de Nueva Ruta -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Nueva Ruta Solicitada
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">
                            Selecciona la nueva ruta <span class="required">*</span>
                        </label>
                        <select name="id_tarifa_solicitada" required class="form-select">
                            <option value="">Seleccionar ruta/destino...</option>
                            @foreach($tarifas as $tarifa)
                                <option value="{{ $tarifa->id_tarifa }}" {{ old('id_tarifa_solicitada') == $tarifa->id_tarifa ? 'selected' : '' }}>
                                    {{ $tarifa->nombre_destino }} - ${{ number_format($tarifa->tarifa, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Motivo de la Solicitud -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Motivo del Cambio
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">
                            Explica por qué solicitas este cambio <span class="required">*</span>
                        </label>
                        <textarea name="motivo" required placeholder="Ejemplo: Cambio de residencia, mejor conocimiento de la zona, solicitud de cliente frecuente..." class="form-textarea" rows="4">{{ old('motivo') }}</textarea>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="form-actions">
                    <button type="button" onclick="window.location.href='{{ route('conductor.dashboard') }}'" class="btn btn-cancelar">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-enviar">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>

        <!-- Historial de Solicitudes -->
        @if($solicitudes->count() > 0)
        <div class="form-card">
            <div class="form-header">
                <h2>Mis Solicitudes Anteriores</h2>
                <p>Historial de solicitudes de cambio de ruta</p>
            </div>

            <div class="form-content">
                <table class="solicitudes-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Ruta Actual</th>
                            <th>Ruta Solicitada</th>
                            <th>Estado</th>
                            <th>Respuesta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->fecha_solicitud->format('d/m/Y') }}</td>
                            <td>{{ $solicitud->tarifaActual->nombre_destino ?? 'N/A' }}</td>
                            <td>{{ $solicitud->tarifaSolicitada->nombre_destino ?? 'N/A' }}</td>
                            <td>
                                <span class="estado-badge estado-{{ strtolower($solicitud->estado) }}">
                                    {{ ucfirst($solicitud->estado) }}
                                </span>
                            </td>
                            <td>{{ $solicitud->respuesta_admin ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    {{ $solicitudes->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success" id="successAlert">
        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error" id="errorAlert">
        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{ $errors->first() }}
    </div>
    @endif

    <script>
        document.getElementById('solicitudForm').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let emptyFields = [];

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    const label = field.closest('.form-group').querySelector('.form-label').textContent.trim();
                    emptyFields.push(label);
                } else {
                    field.classList.remove('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('⚠️ Por favor complete todos los campos obligatorios:\n\n' + emptyFields.join('\n'));
                return false;
            }
        });

        setTimeout(function() {
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            
            if (successAlert) {
                successAlert.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => successAlert.remove(), 300);
            }
            
            if (errorAlert) {
                errorAlert.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => errorAlert.remove(), 300);
            }
        }, 5000);

        document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(field => {
            field.addEventListener('input', function() {
                this.classList.remove('error');
            });
        });
    </script>
</body>
</html>