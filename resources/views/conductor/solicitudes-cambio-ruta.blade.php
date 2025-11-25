<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Cambio Ruta</title>
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
    <div class="header">
        <div class="header-content">
            <span class="header-icon">🔄</span>
            <h1 class="header-title">Solicitudes de Cambio de Ruta</h1>
        </div>
    </div>

    <a href="#" class="btn-volver">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver al Dashboard
    </a>

    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h2>Nueva Solicitud de Servicio</h2>
                <p>Completa el formulario para solicitar un servicio de taxi</p>
            </div>

            <form action="#" method="POST" class="form-content">
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
                                <option value="1">Juan Pérez - CC 123456789</option>
                                <option value="2">María López - CC 987654321</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Vehículo <span class="required">*</span>
                            </label>
                            <select name="id_vehiculo" required class="form-select">
                                <option value="">Seleccionar vehículo...</option>
                                <option value="1">ABC123 - Toyota Corolla</option>
                                <option value="2">XYZ789 - Chevrolet Spark</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Sección: Información del Contratante -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Datos del Contratante
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nombre Completo <span class="required">*</span></label>
                            <input type="text" name="nombre_contratante" required placeholder="Nombre completo del cliente" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Documento <span class="required">*</span></label>
                            <input type="text" name="documento_contratante" required placeholder="Número de documento" class="form-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Teléfono <span class="required">*</span></label>
                        <input type="tel" name="telefono_contratante" required placeholder="Número de contacto" class="form-input">
                    </div>
                </div>

                <!-- Sección: Direcciones -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        Origen y Destino
                    </h3>
                    
                    <!-- CAMPO AGREGADO: Origen Actual -->
                    <div class="form-group">
                        <label class="form-label">Origen Actual <span class="required">*</span></label>
                        <textarea name="origen_actual" required placeholder="Ubicación actual del conductor o punto de partida" class="form-textarea" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dirección de Origen <span class="required">*</span></label>
                        <textarea name="direccion_origen" required placeholder="Dirección completa de recogida" class="form-textarea" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Dirección de Destino <span class="required">*</span></label>
                        <textarea name="direccion_destino" required placeholder="Dirección completa de destino" class="form-textarea" rows="2"></textarea>
                    </div>
                </div>

                <!-- Sección: Detalles del Servicio (OPCIONAL) -->
                <div class="form-section">
                    <h3 class="section-title">
                        <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Detalles del Servicio (Opcional)
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Fecha y Hora Programada</label>
                            <input type="datetime-local" name="fecha_viaje_programada" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Número de Pasajeros</label>
                            <input type="number" name="numero_pasajeros" min="1" value="1" class="form-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tarifa a Cobrar</label>
                        <input type="number" name="tarifa_cobrada" step="0.01" placeholder="0.00" class="form-input">
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="form-actions">
                    <button type="button" onclick="alert('Cancelado')" class="btn btn-cancelar">
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

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            let emptyFields = [];

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#f44336';
                    const label = field.closest('.form-group').querySelector('.form-label').textContent.trim();
                    emptyFields.push(label);
                } else {
                    field.style.borderColor = '#e0e0e0';
                }
            });

            if (!isValid) {
                alert('Por favor complete todos los campos obligatorios:\n\n' + emptyFields.join('\n'));
            } else {
                alert('✅ Formulario válido! Todos los campos están completos.');
            }
        });
    </script>
</body>
</html>