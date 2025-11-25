<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Cambio de Ruta - TAXI EXPRESS</title>
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

        /* Header con gradiente turquesa */
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

        /* Botón Volver */
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

        /* Contenedor principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px 40px;
        }

        /* Card del formulario */
        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
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

        /* Contenido del formulario */
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

        /* Grid de campos */
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

        /* Upload de archivos */
        .file-upload-area {
            border: 2px dashed #00bcd4;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f5fffe;
        }

        .file-upload-area:hover {
            background: #e0f7fa;
            border-color: #00acc1;
        }

        .file-upload-icon {
            width: 48px;
            height: 48px;
            color: #00bcd4;
            margin: 0 auto 15px;
        }

        .file-input {
            display: none;
        }

        .file-text {
            color: #666;
            font-size: 14px;
        }

        .file-hint {
            color: #999;
            font-size: 12px;
            margin-top: 8px;
        }

        /* Botones de acción */
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

        /* Alertas */
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

        /* Responsive */
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
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <span class="header-icon">🔄</span>
            <h1 class="header-title">Solicitudes de Cambio de Ruta</h1>
        </div>
    </div>

    <!-- Botón Volver -->
    <a href="{{ route('conductor.dashboard') }}" class="btn-volver">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver al Dashboard
    </a>

    <!-- Contenedor Principal -->
    <div class="container">
        <div class="form-card">
            <!-- Header del Formulario -->
            <div class="form-header">
                <h2>Nueva Solicitud de Cambio</h2>
                <p>Completa el formulario para solicitar un cambio de ruta</p>
            </div>

            <!-- Contenido del Formulario -->
            <form action="{{ route('conductor.solicitudes.store') }}" method="POST" enctype="multipart/form-data" class="form-content">
                @csrf

                <!-- Sección: Conductor y Vehículo -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Información del Conductor y Vehículo
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                Conductor <span class="required">*</span>
                            </label>
                            <select name="id_conductor" required class="form-select">
                                <option value="">Seleccionar conductor...</option>
                                @foreach($conductores as $conductor)
                                    <option value="{{ $conductor->id_conductor }}">
                                        {{ $conductor->nombre }} {{ $conductor->apellido }} - CC {{ $conductor->cedula }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Vehículo <span class="required">*</span>
                            </label>
                            <select name="id_vehiculo" required class="form-select">
                                <option value="">Seleccionar vehículo...</option>
                                @foreach($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id_vehiculo }}">
                                        {{ $vehiculo->placa }} - {{ $vehiculo->modelo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección: Ruta Actual -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Ruta Actual
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Origen <span class="required">*</span></label>
                            <input type="text" name="origen_actual" required placeholder="Ciudad de origen" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Destino <span class="required">*</span></label>
                            <input type="text" name="destino_actual" required placeholder="Ciudad de destino" class="form-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Código Ruta Actual <span class="required">*</span></label>
                        <input type="text" name="codigo_ruta_actual" required placeholder="Ej: Ruta 45" class="form-input">
                    </div>
                </div>

                <!-- Sección: Nueva Ruta Solicitada -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Nueva Ruta Solicitada
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nuevo Origen <span class="required">*</span></label>
                            <input type="text" name="nuevo_origen" required placeholder="Ciudad de origen" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nuevo Destino <span class="required">*</span></label>
                            <input type="text" name="nuevo_destino" required placeholder="Ciudad de destino" class="form-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Código Nueva Ruta <span class="required">*</span></label>
                        <input type="text" name="codigo_nueva_ruta" required placeholder="Ej: Ruta 23" class="form-input">
                    </div>
                </div>

                <!-- Sección: Motivo y Fecha -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Detalles de la Solicitud
                    </h3>
                    
                    <div class="form-group">
                        <label class="form-label">Motivo de la Solicitud <span class="required">*</span></label>
                        <textarea name="motivo" required placeholder="Explique detalladamente el motivo del cambio de ruta..." class="form-textarea"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Fecha Efectiva del Cambio <span class="required">*</span></label>
                        <input type="date" name="fecha_efectiva" required class="form-input">
                    </div>
                </div>

                <!-- Sección: Documentos -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Documentos de Soporte (Opcional)
                    </h3>
                    
                    <label for="fileInput" class="file-upload-area">
                        <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="file-text">Haz clic para seleccionar archivos</p>
                        <p class="file-hint">PDF, JPG, PNG (Máx. 5MB por archivo)</p>
                    </label>
                    <input type="file" name="documentos[]" multiple accept=".pdf,.jpg,.jpeg,.png" class="file-input" id="fileInput">
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
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{ $errors->first() }}
    </div>
    @endif

    <script>
        // Mostrar nombre del archivo seleccionado
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileCount = e.target.files.length;
            if (fileCount > 0) {
                const fileText = document.querySelector('.file-text');
                fileText.textContent = `${fileCount} archivo(s) seleccionado(s)`;
                fileText.style.color = '#00bcd4';
                fileText.style.fontWeight = '600';
            }
        });

        // Validación del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#f44336';
                } else {
                    field.style.borderColor = '#e0e0e0';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Por favor complete todos los campos obligatorios');
            }
        });

        // Auto-ocultar alertas después de 5 segundos
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>