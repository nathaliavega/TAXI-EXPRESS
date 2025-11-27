<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperadoraController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\TarifaDestinoController;

use Illuminate\Support\Facades\Route;

// RUTAS PÚBLICAS
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/corporativo', function () {
    return view('corporativo');
})->name('corporativo');

// LOGIN
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// RUTAS PROTEGIDAS
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');
    
    // Admin
    Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/vehiculos', [AdminController::class, 'vehiculos'])->name('vehiculos');
        Route::get('/conductores', [AdminController::class, 'conductores'])->name('conductores');
        Route::get('/propietarios', [AdminController::class, 'propietarios'])->name('propietarios');
        Route::get('/alertas', [AdminController::class, 'alertas'])->name('alertas');
        Route::get('/solicitudes-cambio-ruta', [AdminController::class, 'solicitudesCambioRuta'])->name('solicitudes-cambio-ruta');
        Route::get('/mantenimiento-general', [AdminController::class, 'mantenimientoGeneral'])->name('mantenimiento-general');
        Route::post('/mantenimiento-general', [AdminController::class, 'storeMantenimiento'])->name('mantenimiento-general.store');
        Route::put('/mantenimiento-general/{id}', [AdminController::class, 'updateMantenimiento'])->name('mantenimiento-general.update');
        Route::delete('/mantenimiento-general/{id}', [AdminController::class, 'destroyMantenimiento'])->name('mantenimiento-general.destroy');
        // Solicitudes - aprobar/rechazar
        Route::patch('/solicitudes/aprobar/{id}', [AdminController::class, 'aprobarSolicitud'])
            ->name('solicitudes.aprobar');
        Route::patch('/solicitudes/rechazar/{id}', [AdminController::class, 'rechazarSolicitud'])
            ->name('solicitudes.rechazar');
        
        // ⬇️ TARIFAS DESTINO - SOLO ESTAS DOS RUTAS
        Route::get('/tarifas-destino', [TarifaDestinoController::class, 'index'])->name('tarifas-destino');
        Route::post('/tarifas-destino', [TarifaDestinoController::class, 'store'])->name('tarifas-destino.store');
        Route::put('/tarifas-destino/{id}', [TarifaDestinoController::class, 'update'])->name('tarifas-destino.update');
        Route::delete('/tarifas-destino/{id}', [TarifaDestinoController::class, 'destroy'])->name('tarifas-destino.destroy');
        Route::get('/servicio-mantenimiento', [AdminController::class, 'servicioMantenimiento'])->name('admin.servicio-mantenimiento');
        Route::get('/fix-estados', function() {
        DB::table('tarifas_destinos')
            ->whereNull('estado')
            ->orWhere('estado', '')
            ->update(['estado' => 'Activa']);
        
        return "Estados actualizados correctamente";
    });
    });
    
    // Operadora
    Route::middleware(['auth', 'checkRole:operadora'])->prefix('operadora')->name('operadora.')->group(function () {
        Route::get('/dashboard', [OperadoraController::class, 'dashboard'])->name('dashboard');
        Route::get('/control-turnos', [OperadoraController::class, 'controlTurnos'])->name('control-turnos');
        Route::put('/control-turnos/{id}', [OperadoraController::class, 'updateControlTurno'])->name('control-turnos.update');
        Route::delete('/control-turnos/{id}', [OperadoraController::class, 'deleteControlTurno'])->name('control-turnos.destroy');
        Route::get('/turnos-obligatorios', [OperadoraController::class, 'turnosObligatorios'])->name('turnos-obligatorios');
        Route::post('/turnos-obligatorios', [OperadoraController::class, 'storeTurnoObligatorio'])->name('turnos-obligatorios.store');
        Route::put('/turnos-obligatorios/{id}', [OperadoraController::class, 'updateTurnoObligatorio'])->name('turnos-obligatorios.update');
        Route::delete('/turnos-obligatorios/{id}', [OperadoraController::class, 'destroyTurnoObligatorio'])->name('turnos-obligatorios.destroy');
        
        Route::get('/vehiculos', [OperadoraController::class, 'vehiculos'])->name('vehiculos');
        
    });
    
    // Conductores
    Route::middleware(['auth'])->prefix('conductor')->name('conductor.')->group(function () {
        Route::get('/dashboard', [ConductorController::class, 'dashboard'])->name('dashboard');
        Route::get('/mis-turnos', [ConductorController::class, 'misTurnos'])->name('mis-turnos');
        Route::get('/alertas', [ConductorController::class, 'alertas'])->name('alertas');
        Route::get('/conductores', [ConductorController::class, 'conductores'])->name('conductores');
        Route::get('/mantenimiento-general', [ConductorController::class, 'mantenimientoGeneral'])->name('mantenimiento-general');
        
        // Solicitudes de cambio de ruta
        Route::get('/solicitudes-cambio-ruta', [ConductorController::class, 'solicitudesCambioRuta'])
            ->name('solicitudes-cambio-ruta');
        Route::post('/solicitudes-cambio-ruta', [ConductorController::class, 'storeSolicitudCambioRuta'])
            ->name('solicitudes-cambio-ruta.store');
        
        Route::get('/tarifas', [ConductorController::class, 'tarifas'])->name('tarifas');
        Route::get('/vehiculos', [ConductorController::class, 'vehiculos'])->name('vehiculos');
    });
});